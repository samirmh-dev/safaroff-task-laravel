<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SehifeTitle extends Model
{
	protected $table='sehife_titles';
	protected $fillable=['basliq','qisa_mezmun'];
	public function sehife(){
		return $this->belongsTo('App\Sehifeler');
	}
}
