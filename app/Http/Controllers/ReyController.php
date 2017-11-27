<?php

namespace App\Http\Controllers;

use App\PostModel;
use App\PostReyler;
use App\PostReylerContent;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReyController extends Controller
{
	//reyin bazaya elavesi, cavab olaraq ajax sorgusuna birsey qaytarmir.
	//ajax sorgusunda success deyisenini yoxlamisam tekce
	public function add(Request $request,$post_id) {
		$rey_content=$request->toArray()['rey'];

		//yeni rey yaradir
		$yeni_rey=new PostReyler;
		$yeni_rey->fk_post_id=$post_id;

		//reyi yazan useri tapit
		$userid=User::find(Auth::user()->id*1);

		//reyin elave edilmesi
		$userid->rey()->save($yeni_rey);

		//contenin elavesi ucun reyin id`sini tapir, buda en son elave olunan rey olur tebii ki
		$rey=PostReyler::where('fk_post_id','=',$post_id*1)->orderBy('id','desc')->first();

		//contenti yaradir
		$content=new PostReylerContent([
			'rey'=>htmlspecialchars( trim( $rey_content))
		]);

		//bazaya elave edir
		$rey->content()->save($content);
    }

    public function baxis(){

		//admin panelinde reylere baxis ucun. Reyleri tersden siralayir. En son yazilan birinci
	    //gelsin die
		$reyler=PostReyler::orderBy('id','desc')->paginate(8);
		return view('admin.reyler',compact('reyler'));
    }

	public function sil($id) {
    	//reyi silir ve evvelki sehifeye kecid edir.
		PostReyler::find($id*1)->delete();
		return back();
    }
}
