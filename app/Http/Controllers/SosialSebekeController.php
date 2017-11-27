<?php

namespace App\Http\Controllers;

use App\SosialSebeke;
use Illuminate\Http\Request;
use function redirect;

class SosialSebekeController extends Controller
{
	public function edit() {
		//deyisdirmek ucun olan form`a kecir
		return view('admin.sosial-sebeke');
	}

	//bazada deyisiklikler
	public function update(Request $request) {
		$data=$request->toArray();

		if(isset($data['facebook'])){
			SosialSebeke::where('ad','=','facebook')->update([
				'link'=>htmlspecialchars( trim( $data['facebook']))
			]);
		}

		if(isset($data['twitter'])){
			SosialSebeke::where('ad','=','twitter')->update([
				'link'=>htmlspecialchars( trim( $data['twitter']))
			]);
		}

		if(isset($data['github'])){
			SosialSebeke::where('ad','=','github')->update([
				'link'=>htmlspecialchars( trim( $data['github']))
			]);
		}

		return redirect()->route( 'sosial-sebeke-edit');
	}
}
