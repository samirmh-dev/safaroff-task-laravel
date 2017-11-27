<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SehifeLink extends Model
{
	protected $table='sehife_link';
	protected $fillable=['link'];
	public function sehife(){
		return $this->belongsTo('App\Sehifeler');
	}
}
