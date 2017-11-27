<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sehifeler extends Model
{
    protected $table='sehifeler';

    //sehife adina muraciet ucun
	public function ad(){
		return $this->hasOne('App\SehifeAd','fk_sehife_id');
	}

	public function link(){
		return $this->hasOne('App\SehifeLink','fk_sehife_id');
	}

	public function content(){
		return $this->hasOne('App\SehifeContent','fk_sehife_id');
	}

	public function title(){
		return $this->hasOne('App\SehifeTitle','fk_sehife_id');
	}

	public function sekil(){
		return $this->hasOne( 'App\SehifeSekil','fk_sehife_id');
	}

	public static function sehifeler() {
		$sehifeler=Sehifeler::select('id')->get()->toArray();
		foreach ($sehifeler as $index=>$sehife){
			$id=Sehifeler::find($sehife['id']);
			$sehifeler[$index]['ad']=$id->ad()->get()->first()->toArray()['ad'];
			$sehifeler[$index]['link']=$id->link()->get()->first()->toArray()['link'];
		}
		return $sehifeler;
	}
}
