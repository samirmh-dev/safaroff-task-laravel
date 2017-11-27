<?php

namespace App\Http\Controllers;

use App\EsasSehifeMelumatlari;
use App\Sehifeler;
use Illuminate\Http\Request;
use App\PostModel;
use Mail;

class IndexController extends Controller
{
	//Butun postlari id`ye gore ters istiqametde (en basda en son elave olunan postlarin
	//gorunmeyi ucun) siralayir. Ve postlari sehifelemek ucun 3-3 bolur. Her sehifede 3 post olur.
	public function index() {

		$postlar=PostModel::orderBy('id','desc')->paginate(3);

		$sehife['basliq']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','basliq')->get()->first()->toArray()['melumat'];

		$sehife['qisamezmun']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','qisa_mezmun')->get()->first()->toArray()['melumat'];

		$sehife['sekil']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','sekil')->get()->first()->toArray()['melumat'];

		$sehife['title']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','title')->get()->first()->toArray()['melumat'];

		return view('index',['postlar'=>$postlar,'sehife'=>$sehife]);
    }

	//About sehifesi
	public function about() {
		return view('about');
    }

	//Contact sehifesi
	public function contact() {
		return view('contact');
	}

	//Contact sehifesi. Mail.
	public function mail(Request $request) {
		$data=$request->toArray();

		//validation ugursuz olsa evvelki sehifeye atacaq
		$request->validate( [
			'ad'=>'required|string',
			'email'=>'required|email',
			'telefon'=>'required|string',
			'mesaj'=>'required|string'
		]);

		Mail::send('mail.contact',$data,function($message) use ($data){
			$message->to(env('MAIL_USERNAME'));
			$message->subject('Contact form`dan mail');
		});

		//contact sehifesine yeniden status ile yonlendirecek
		return back()->with('status',true);
	}
}
