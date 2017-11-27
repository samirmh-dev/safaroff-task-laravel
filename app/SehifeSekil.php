<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SehifeSekil extends Model
{
	protected $table='sehife_sekil';
	protected $fillable=['sekil'];
	public function sehife(){
		return $this->belongsTo('App\Sehifeler');
	}
}
