<?php

namespace App\Http\Controllers;

use App\PostImage;
use App\PostLink;
use App\PostMetn;
use App\PostModel;
use App\PostReyler;
use App\PostTitle;
use App\Sehifeler;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;

class PostController extends Controller
{
	/**
	 * Postlara baxis ucun. Link qebul edir ve bu linke uygun id-ni bazadan goturur.
	 * Sonra ise table-lar arasi elaqeler ile melumatlari elde edir.
	 *
	 */
	public function postakecid($link) {

		//linke uygun olaraq postun id nomresini bazadan cekir
		$id=PostLink::select('for_post')->where('link','=',htmlspecialchars( mb_strtolower(trim(rtrim($link,'/')))))->get()->first();

		//eger bele bir post varsa davam edir, yoxdursa 404 qaytarir
		if($id!==NULL){
			$id=$id->toArray()['for_post'];

			//bazadan goturulen id`ye uygun olan postu secir
			$post=PostModel::find($id*1);

			//postun melumatlarini bazadan cekir ve $post_melumat massivine elave edir
			$post_melumat['sekil']=$post->sekil()->get()->first()->toArray()['sekil'];
			$post_melumat['basliq']=$post->title()->get()->first()->toArray()['title'];
			$post_melumat['qisa_mezmun']=$post->title()->get()->first()->toArray()['title2'];
			$post_melumat['metn']=$post->metn()->get()->first()->toArray()['metn'];
			$post_melumat['yazan']=$post->postu_yazan()->get()->first()->toArray()['name'];
			$post_melumat['tarix']=$post->select('created_at')->where('id','=',$id)->get()->first()->toArray()['created_at'];
			$post_melumat['reyler']=$post->rey()->select('id')->get()->toArray();

			//reyleri bazadan cekir
			foreach ($post_melumat['reyler'] as $index=>$rey){
				$_rey=PostReyler::find($rey['id']*1);
				$post_melumat['reyler'][$index]['tarix']=$_rey->select('created_at')->where('id','=',$rey['id']*1)->get()->first()->toArray()['created_at'];
				$post_melumat['reyler'][$index]['content']=$_rey->content()->get()->first()->toArray()['rey'];
				$post_melumat['reyler'][$index]['rey_yazan']=$_rey->rey_yazan()->get()->first()->toArray()['name'];
			}


			//bazanin tehlukesizliyi ucun bazaya daxil olan butun melumatlarda html teqlerini kodlasdirmisiq.
			//bazadan oxuyandan sonrada postun duzgun gorunmeyi ucun hemin html teqlerini dekodlasdirir
			$post_melumat['metn']=htmlspecialchars_decode( $post_melumat['metn']);

			//bazada timestamp kimi saxlanilan tarixleri oxuna bilen formaya getirir
			$post_melumat['tarix']=date('M j Y H:i', strtotime($post_melumat['tarix']));

			return view('post',compact(['post_melumat','id']));
		}else{
			//bele post yoxdur, kecir -> 404
			throw new NotFoundHttpException();
		}
	}

    /**
     * admin panelinde postlar bolmesinde herbir postun gorunmeyi ucun
     *
     */
    public function index()
    {
    	//postlari bazadan cekir. en son yazilan postun birinci gorunmeyi ucun tersden siralayir
    	$postlar=PostModel::select('id','created_at','updated_at')->orderBy('id','desc')->get()->toArray();

    	//herbir post ucun bezi melumatlari bazadan cekir
    	foreach ($postlar as $index=>$post) {
		    $baxilan_post = PostModel::find( $post['id'] );

		    $postlar[ $index ]['yazan'] = $baxilan_post->postu_yazan()->select('name')->get()->first()->toArray()['name'];

		    $postlar[ $index ]['link'] = $baxilan_post->link()->select('link')->get()->first()->toArray()['link'];

		    $postlar[ $index ]['basliq'] = $baxilan_post->title()->select('title')->get()->first()->toArray()['title'];
	    }
        return view('admin.post.bax',compact('postlar'));
    }

    /**
     * Yeni postun elave edilmesi ucun
     *
     */
    public function create()
    {
        return view('admin.post.yeni');
    }

    /**
     * Yeni elave olunmus postu bazaya elave etmek ucun
     *
     */
    public function store(Request $request)
    {
    	$data=$request->toArray();
    	// 5.5 versiyasi ile gelen yenilenme
	    $request->validate([
		    'basliq1'=>'required|string',
			'basliq2'=>'required|string',
		    'link'=>'required|string|unique:post_links',
		    'fon'=>'required|image|mimes:jpg,jpeg,png,gif',
		    'metn'=>'required|string'
	        ],[
		    'basliq1.required'=>'Başlıq yazılmalıdır',
		    'basliq2.required'=>'Qısa məzmun yazılmalıdır',
		    'link.required'=>'Link yazılmalıdır',
		    'link.unique'=>'Bu link artıq var',
		    'fon.required'=>'Fon üçün şəkil seçilməlidir',
		    'fon.image'=>'Fon üçün seçilmiş fayl şəkil olmalıdır',
		    'fon.mimes'=>'Fon üçün seçilmiş fayl tipi düzgün deyil. Mümkün tiplər: JPG, JPEG, PNG, GIF',
		    'metn.required'=>'Mətn yazılmalıdır',
	    ]);

	    $id=Auth::user()->id;

		$post=new PostModel;

		$post->by_user=$id;

		$post->save();

		//postlar olan table da elave olunan son postun id`ni goturur
		$id=PostModel::select('id')->where('by_user','=',$id)->orderBy('id','desc')->first()->toArray()['id'];

		//bazadan elde olunan id`ye uygun postu secir
		$post=PostModel::find($id);

		//Linkin bazaya elavesi
		$temp=new PostLink([
			'link'=> htmlspecialchars( mb_strtolower( trim($data['link'])))
		]);
		$post->link()->save($temp);

	    //Metnin bazaya elavesi
	    $temp=new PostMetn([
		    'metn'=>htmlspecialchars(trim($data['metn']))
	    ]);
	    $post->link()->save($temp);

	    //Basliqin ve qisa mezmunun bazaya elavesi
	    $temp=new PostTitle([
		    'title'=>htmlspecialchars( mb_strtolower( trim($data['basliq1']))),
		    'title2'=>htmlspecialchars( mb_strtolower( trim($data['basliq2'])))
	    ]);
	    $post->title()->save($temp);

		//Şəkillərin servere elaesi
	    $ad=time().rand(0,999).'.'.$data['fon']->getClientOriginalExtension();
	    $yuklenecek_unvan=public_path('/src/images/');
	    $data['fon']->move($yuklenecek_unvan,$ad);

	    //sekilin adinin bazaya elavesi
	    $temp=new PostImage([
	    	'sekil'=>htmlspecialchars( mb_strtolower( trim($ad)))
	    ]);
	    $post->sekil()->save($temp);

	    //hecbir exception olmadigi halda umumi postlar olan sehifeye yonlendirir
	    return redirect()->route('post.bax');
    }

    /**
     * Secilmis postun gosterilmesi ucun
     *
     */
    public function show($id)
    {
    	//verilen linki postakec adli route`a yonlendirir.
	    //sonra linke uygun olan postun id`i goturulecek ve
	    //id`e uygun melumatlar bazadan cekilecek
	    return redirect()->route('postakec',['link'=>$id]);
    }

    /**
     * Postun redaktesi ucun
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
    	//postu tapir
    	$post=PostModel::find($id);

    	//posta uygun melumatlari elde edir
	    $post_melumat['basliq']=$post->title()->get()->first()->toArray()['title'];
	    $post_melumat['qisa_mezmun']=$post->title()->get()->first()->toArray()['title2'];
	    $post_melumat['metn']=$post->metn()->get()->first()->toArray()['metn'];
	    $post_melumat['link']=$post->link()->get()->first()->toArray()['link'];
	    $post_melumat['sekil']=$post->sekil()->get()->first()->toArray()['sekil'];


	    return view('admin.post.edit',compact('post_melumat','id'));
    }

    /**
     * Postun redakte olunmasindan sonra bazada deyisikliklerin aparilmasi ucun
     */
    public function update(Request $request, $id)
    {
    	//form ile gelen melumatlari elde edir
        $data=$request->toArray();

        //eger basliq deyisdirilibse bazada`da deyisiklik aparir
        //post ucun olan linkde basliqa esasen mueyyen olundugu ucun
	    //basliq deyisdikde linkde deyisilecek.
	    //eger ancaq link deyisdirilibse bunu ayrica nezere almisam
        if(isset($data['basliq1'])){
        	$request->validate( [
	            'basliq1'=>'required|string'
        	],[
		        'basliq1.required'=>'Başlıq yazılmalıdır',
	        ]);

	        $post=PostModel::find($id*1);

        	$post->title()->update([
        		'title'=>htmlspecialchars( trim( mb_strtolower($data['basliq1'])))
	        ]);

        	$post->link()->update([
		        'link'=>htmlspecialchars( trim( mb_strtolower($data['link'])))
	        ]);
        }

	    //eger qisa mezmun deyisdirilibse bazada`da deyisiklik aparir
	    if(isset($data['basliq2'])){
	        $request->validate( [
		        'basliq2'=>'required|string'
	        ],[
		        'basliq2.required'=>'Qısa məzmun yazılmalıdır',
	        ]);

	        $post=PostModel::find($id*1);

	        $post->title()->update([
		        'title2'=>htmlspecialchars( trim( mb_strtolower($data['basliq2'])))
	        ]);
        }

	    //eger link ayrica deyisdirilibse basliq redakte olunmamis olmalidir.
	    // eger basliq redakte olunubsa bu yuxaridaki funksiyada nezere alinib ve
	    // link artiq orada da yenilenib demekdir bu. buna gore de linki birde yenilemeye ehtiyac yoxdur
	    if(isset($data['link']) && !isset($data['basliq1'])){
	        $request->validate( [
		        'link'=>'required|string|unique:post_links',
	        ],[
		        'link.required'=>'Link yazılmalıdır',
	            'link.unique'=>'Bu link artıq var',
	        ]);

	        $post=PostModel::find($id*1);

	        $post->link()->update([
		        'link'=>htmlspecialchars( trim( mb_strtolower($data['link'])))
	        ]);
        }

	    //eger sekil deyisdirilibse bazada`da deyisiklik aparir
	    if(isset($data['fon'])){
	        $request->validate( [
		        'fon'=>'required|image|mimes:jpg,jpeg,png,gif',
	        ],[
		        'fon.required'=>'Fon üçün şəkil seçilməlidir',
	            'fon.image'=>'Fon üçün seçilmiş fayl şəkil olmalıdır',
		        'fon.mimes'=>'Fon üçün seçilmiş fayl tipi düzgün deyil. Mümkün tiplər: JPG, JPEG, PNG, GIF',
	        ]);

	        //id`e uygun olan sekili secir
		    $post=PostModel::find($id*1);

		    //evvelki sekili serverden silmek ucun evvelce evvelki seklin adini bazadan goturur
		    //silme emeliyyati en sonda olacaq
	        $sekil=$post->sekil()->select('sekil')->get()->first()->toArray()['sekil'];
	        $unvan=public_path().'/src/images/'.$sekil;

	        //yeni sekil ucun yeni ad secir
	        $ad=time().rand(0,999).'.'.$data['fon']->getClientOriginalExtension();
	        //yeni sekilin kocuruleceyi unvan
	        $yuklenecek_unvan=public_path('/src/images/');
	        //yeni sekili kocurur
	        $data['fon']->move($yuklenecek_unvan,$ad);

	        //bazada kohne sekilin adini yeni sekilin adi ile evez edir
	        $post->sekil()->update([
		        'sekil'=>htmlspecialchars( trim( mb_strtolower($ad)))
	        ]);

	        //kohne sekili serverden silir
	        File::delete($unvan);
        }

        //eger metn deyisdirilibse bazada deyisiklik aparir
        if(isset($data['metn'])){
	        $request->validate( [
		        'metn'=>'required|string'
	        ],[
		        'metn.required'=>'Mətn yazılmalıdır',
	        ]);

	        $post=PostModel::find($id*1);

	        $post->metn()->update([
		        'metn'=>htmlspecialchars( trim($data['metn']))
	        ]);
        }


        return redirect()->route('post.bax');
    }

    /**
     * Postu bazadan silir
     */
    public function destroy($id)
    {
    	// stringi int-ə çevirmək üçün 1-ə vura bilərik
	    //silinecek post ucun verilen id`nin heqiqeten reqem oldugunu yoxlayir
	    if(is_int($id*1)){
	    	//postu tapir
		    $post=PostModel::find($id*1);
			//post ucun olan seklin adini postu silmemisden qabaq bazadan goturur
		    $sekil=$post->sekil()->select('sekil')->get()->first()->toArray()['sekil'];
			//silinecek unvan
		    $unvan=public_path().'/src/images/'.$sekil;
			//sekilin serverden silinmesi
		    File::delete($unvan);
			//postun bazadan tamamile silinmesi
		    //(foreign key yaradilarken eger post silinerse hemin postla bagli diger melumatlarinda
		    // silinmesi qeyd olunduguna gore tekca posts table`indan postun ozunu silmek kifayet edir)
		    $post->delete();
		    return redirect()->route('post.bax'); //todo: en sonda routun adini deyis
	    }else{
	    	//eger post ucun olan id duzgun deyilse umumi postlar olan sehifeye yonlendir
		    return redirect()->route('post.bax');
	    }
    }
}
