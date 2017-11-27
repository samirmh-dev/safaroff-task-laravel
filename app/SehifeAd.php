<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SehifeAd extends Model
{
	protected $table='sehife_ad';
	protected $fillable=['ad'];
	public function sehife(){
		return $this->belongsTo('App\Sehifeler');
	}
}
