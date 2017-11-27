<?php

namespace App\Http\Controllers;

use App\EsasSehifeMelumatlari;
use File;
use Illuminate\Http\Request;

class EsasSehifeController extends Controller
{
	//admin panelinde esas sehifedeki melumatlari deyismek ucun olan sehifeni acir
	public function index() {
		//melumatlari bazadan cekir
		$sehife['basliq']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','basliq')->get()->first()->toArray()['melumat'];

		$sehife['qisamezmun']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','qisa_mezmun')->get()->first()->toArray()['melumat'];

		$sehife['sekil']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','sekil')->get()->first()->toArray()['melumat'];

		$sehife['title']=EsasSehifeMelumatlari::select('melumat')->where('ad','=','title')->get()->first()->toArray()['melumat'];

		return view('admin.esas_sehife_melumatlari',compact( 'sehife'));
    }

    //bazada deyisiklik ucun
	public function deyisdir(Request $request)  {
		$data=$request->toArray();
		$request->validate([
			'title'=>'string',
			'sehifebasliq'=>'string',
			'qisamezmun'=>'string',
			'fon'=>'image|mimes:jpg,jpeg,png,gif'
		]);

		if(isset($data['title'])){
			EsasSehifeMelumatlari::where('ad','=','title')->update([
				'melumat'=>htmlspecialchars( trim( $data['title']))
			]);
		}

		if(isset($data['sehifebasliq'])){
			EsasSehifeMelumatlari::where('ad','=','basliq')->update([
				'melumat'=>htmlspecialchars( trim( $data['sehifebasliq']))
			]);
		}

		if(isset($data['qisamezmun'])){
			EsasSehifeMelumatlari::where('ad','=','qisa_mezmun')->update([
				'melumat'=>htmlspecialchars( trim( $data['qisamezmun']))
			]);
		}

		if(isset($data['fon'])){

			//kohne sekili silmek ucun bazadan adini goturur
			$sekil_adi=EsasSehifeMelumatlari::select('melumat')->where( 'ad','=','sekil')->get()->first()->toArray()['melumat'];

			//sekilin adina uygun silinecek unvani teyin edir
			$unvan=public_path().'/src/images/'.$sekil_adi;

			//yeni sekil ucun yeni ad secir
			$ad=time().rand(0,999).'.'.$data['fon']->getClientOriginalExtension();
			//yeni sekilin kocuruleceyi unvan
			$yuklenecek_unvan=public_path('/src/images/');
			//yeni sekili kocurur
			$data['fon']->move($yuklenecek_unvan,$ad);

			//bazada kohne sekilin adini yeni sekilin adi ile evez edir
			EsasSehifeMelumatlari::where('ad','=','sekil')->update([
				'melumat'=>htmlspecialchars( trim( $ad))
			]);

			//kohne sekili serverden silir
			File::delete($unvan);
		}
		
		return redirect()->route( 'esas-sehife-melumatlari.index');
    }
}
