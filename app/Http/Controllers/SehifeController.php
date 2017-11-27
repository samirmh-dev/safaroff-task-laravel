<?php

namespace App\Http\Controllers;

use App\SehifeAd;
use App\SehifeContent;
use App\Sehifeler;
use App\SehifeLink;
use App\SehifeSekil;
use App\SehifeTitle;
use File;
use function htmlspecialchars;
use function htmlspecialchars_decode;
use Illuminate\Http\Request;
use function in_array;
use function mb_strtolower;
use function redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SehifeController extends Controller
{
	/*
	 * yaradilan sehifelere baxmaq
	 */
	public function bax($link) {
		//giris edilen linkin hansisa bir sehifeye aid olub olmadigi yoxlanilir

		//butun sehifeler elde edilir
		$sehifeler=Sehifeler::select('id')->get()->toArray();

		foreach ( $sehifeler as $index=>$sehife ) {
			//sehife id`sine gore hemin sehifenin linki elde edilir
			$id=Sehifeler::find($sehife['id']);

			//sonda butun movcud sehifelerin linki bu massivde olacaq
			$check_sehifeler[]=$id->link()->get()->first()->toArray()['link'];
		}

		//linki formaya salir
		$link=trim(mb_strtolower($link));


		//hazirki linkin butun linkler olan massivde olub olmadigini yoxlayir
		//varsa davam edir
		//yoxdursa 404 qaytarir
		if(in_array($link,$check_sehifeler)){

			//contact sehifesindeki formu gostermek ucun linkin "contact" oldugunu yoxlayir
			if($link=='contact'){
				$contact=true;
			}else{
				$contact=false;
			}

			//linke uygun sehifenin id`sini elde edir
			$id=SehifeLink::select('fk_sehife_id')->where('link','=',$link)->get()->first()->toArray()['fk_sehife_id'];

			//sehifeni bazada tapir
			$id=Sehifeler::find($id*1);

			// sehife melumatlarini elde edir
			$sehife['sehifebasliq']=$id->title()->get()->first()->toArray()['basliq'];
			$sehife['qisamezmun']=$id->title()->get()->first()->toArray()['qisa_mezmun'];
			$sehife['sekil']=$id->sekil()->get()->first()->toArray()['sekil'];
			$sehife['content']=htmlspecialchars_decode( $id->content()->get()->first()->toArray()['content']);

			unset($sehife['id']);

			return view('sehife',compact(['sehife','contact']));
		}else{
			throw new NotFoundHttpException();
		}
	}

    /**
     * butun sehifelerin cedvel ile gosterilmesi
     */
    public function index()
    {
    	$sehifeler=Sehifeler::select('id','created_at')->get()->toArray();

	    foreach ( $sehifeler as $index=>$sehife ) {
	    	$id=Sehifeler::find($sehife['id']);
		    $sehifeler[$index]['ad']=$id->ad()->get()->first()->toArray()['ad'];
		    $sehifeler[$index]['link']=$id->link()->get()->first()->toArray()['link'];
		    $sehifeler[$index]['content']=htmlspecialchars_decode( $id->content()->get()->first()->toArray()['content']);
    	}
        return view('admin.sehife.index',compact(['sehifeler']));
    }

    /**
     * yeni sehifenin yaradilmasi ucun
     *
     */
    public function create()
    {
        return view('admin.sehife.create');
    }

    /**
     *  yeni yaradilan sehifenin bazaya elavesi
     *
     */
    public function store(Request $request)
    {
        $data=$request->toArray();

        //eger uygunsuzluq varsa evvelki sehifeye xeta aciqlamalari ile qayidaceaq
	    // - laravel v5.5 yenilenmesi
        $request->validate([
	        'ad'=>'required|string|unique:sehife_ad',
        	'link'=>'required|string|unique:sehife_link',
	        'sehifebasliq'=>'required|string',
	        'qisamezmun'=>'required|string',
	        'content'=>'required|string',
	        'fon'=>'required|image|mimes:jpg,jpeg,png,gif',
        ],[
        	'ad.required'=>'Ad yazılmalıdır',
	        'ad.unique'=>'Bu səhifə adı artıq istifadə olunur. Yeni ad seçin.',
	        'sehifebasliq.required'=>'Başlıq yazılmalıdır',
	        'qisamezmun.required'=>'Qısa məzmun yazılmalıdır',
	        'link.required'=>'Link yazılmalıdır',
	        'link.unique'=>'Bu link artıq istifadə olunur. Yeni link seçin.',
	        'content.required'=>'Səhifə üçün mətn yazılmalıdır',
	        'fon.required'=>'Fon üçün şəkil seçilməlidir',
	        'fon.image'=>'Fon üçün seçilmiş fayl şəkil tipli olmalıdır',
	        'fon.mimes'=>'Fon üçün seçilmiş fayl tipi düzgün deyil. Mümkün tiplər: JPG, JPEG, PNG, GIF',
        ]);

        //foreign key ucun olan funksiyalarda istifade etmek ucun id`e ehtiyacim var
	    //bu sebebden yeni bir sehife yaradaraq id yaradiram
        $sehife=new Sehifeler();
		$sehife->save();

		//hemin id yaratdigim son setirdeki id olacaq onu elde edirem
		$sehife=Sehifeler::orderBy('id','desc')->limit(1)->select('id')->get()->first()->toArray()['id'];

		//sonra hemin sehifeni elde edirem
		$sehife=Sehifeler::find($sehife);

		//yeni adin yaradilmasi
        $ad=new SehifeAd([
        	'ad'=>trim(htmlspecialchars( mb_strtolower($data['ad'])))
        ]);
        //yeni adin bazaya elavesi
        $sehife->ad()->save($ad);

	    //yeni linkin yaradilmasi
	    $link=new SehifeLink([
		    'link'=>trim(htmlspecialchars( mb_strtolower($data['link'])))
	    ]);
	    //yeni linkin bazaya elavesi
	    $sehife->link()->save($link);

	    //yeni basligin yaradilmasi
	    $link=new SehifeTitle([
		    'basliq'=>trim(htmlspecialchars( mb_strtolower($data['sehifebasliq']))),
		    'qisa_mezmun'=>trim(htmlspecialchars( mb_strtolower($data['qisamezmun'])))
	    ]);
	    //yeni basliq ve qisa mezmunun bazaya elavesi
	    $sehife->title()->save($link);

	    //yeni contentin yaradilmasi
	    $content=new SehifeContent([
		    'content'=>trim(htmlspecialchars( mb_strtolower($data['content'])))
	    ]);
	    //yeni contentin bazaya elavesi
	    $sehife->content()->save($content);

	    //Şəkillərin servere elaesi
	    $ad=time().rand(0,999).'.'.$data['fon']->getClientOriginalExtension();
	    $yuklenecek_unvan=public_path('/src/images/');
	    $data['fon']->move($yuklenecek_unvan,$ad);

	    //sekilin adinin bazaya elavesi
	    $sekil=new SehifeSekil([
		    'sekil'=>htmlspecialchars( mb_strtolower( trim($ad)))
	    ]);
	    $sehife->sekil()->save($sekil);

	    //sehifeler.index`ə yonlendirir
		return redirect()->route('sehifeler.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $_sehife=Sehifeler::find($id*1);
	    $sehife['ad']=$_sehife->ad()->get()->first()->toArray()['ad'];
	    $sehife['link']=$_sehife->link()->get()->first()->toArray()['link'];
	    $sehife['sehifebasliq']=$_sehife->title()->get()->first()->toArray()['basliq'];
	    $sehife['qisamezmun']=$_sehife->title()->get()->first()->toArray()['qisa_mezmun'];
	    $sehife['sekil']=$_sehife->sekil()->get()->first()->toArray()['sekil'];
	    $sehife['content']=htmlspecialchars_decode( $_sehife->content()->get()->first()->toArray()['content']);

	    return view('admin.sehife.edit',compact('id','sehife'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
    	$data=$request->toArray();
	    $request->validate([
		    'ad'=>'string|unique:sehife_ad',
		    'link'=>'string|unique:sehife_link',
		    'sehifebasliq'=>'string',
		    'qisamezmun'=>'string',
		    'content'=>'string',

	    ],[
		    'ad.unique'=>'Bu səhifə adı artıq istifadə olunur. Yeni ad seçin.',
		    'link.unique'=>'Bu link artıq istifadə olunur. Yeni link seçin.',
	    ]);

	    $sehife=Sehifeler::find($id*1);

	    if(isset($data['ad'])){
		    $sehife->ad()->update([
		    	'ad'=>trim(htmlspecialchars( mb_strtolower($data['ad'])))
		    ]);
	    }

	    if(isset($data['link'])){
		    $sehife->link()->update([
			    'link'=>trim(htmlspecialchars( mb_strtolower($data['link'])))
		    ]);
	    }

	    if(isset($data['sehifebasliq'])){
		    $sehife->title()->update([
			    'basliq'=>trim(htmlspecialchars( mb_strtolower($data['sehifebasliq'])))
		    ]);
	    }

	    if(isset($data['qisamezmun'])){
		    $sehife->title()->update([
			    'qisa_mezmun'=>trim(htmlspecialchars( mb_strtolower($data['qisamezmun'])))
		    ]);
	    }

	    if(isset($data['content'])){
		    $sehife->content()->update([
			    'content'=>trim(htmlspecialchars( mb_strtolower($data['content'])))
		    ]);
	    }

	    if(isset($data['fon'])){
		    $request->validate( [
			    'fon'=>'required|image|mimes:jpg,jpeg,png,gif',
		    ],[
			    'fon.required'=>'Fon üçün şəkil seçilməlidir',
			    'fon.image'=>'Fon üçün seçilmiş fayl şəkil olmalıdır',
			    'fon.mimes'=>'Fon üçün seçilmiş fayl tipi düzgün deyil. Mümkün tiplər: JPG, JPEG, PNG, GIF',
		    ]);

		    //id`e uygun olan sekili secir
		    $sekil=Sehifeler::find($id*1);

		    //evvelki sekili serverden silmek ucun evvelce evvelki seklin adini bazadan goturur
		    //silme emeliyyati en sonda olacaq
		    $sekil_adi=$sekil->sekil()->select('sekil')->get()->first()->toArray()['sekil'];
		    $unvan=public_path().'/src/images/'.$sekil_adi;

		    //yeni sekil ucun yeni ad secir
		    $ad=time().rand(0,999).'.'.$data['fon']->getClientOriginalExtension();
		    //yeni sekilin kocuruleceyi unvan
		    $yuklenecek_unvan=public_path('/src/images/');
		    //yeni sekili kocurur
		    $data['fon']->move($yuklenecek_unvan,$ad);

		    //bazada kohne sekilin adini yeni sekilin adi ile evez edir
		    $sekil->sekil()->update([
			    'sekil'=>htmlspecialchars( trim( mb_strtolower($ad)))
		    ]);

		    //kohne sekili serverden silir
		    File::delete($unvan);
	    }

	    return redirect()->route( 'sehifeler.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
    	$sehife=Sehifeler::find($id*1);
    	//bele bir sehife varsa silir
        if($sehife!==NULL) {
	        $sehife->delete();
        }
	    return redirect()->route( 'sehifeler.index' );
    }
}
