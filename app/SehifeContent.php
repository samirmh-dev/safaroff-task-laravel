<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SehifeContent extends Model
{
	protected $table='sehife_content';
	protected $fillable=['content'];
	public function sehife(){
		return $this->belongsTo('App\Sehifeler');
	}
}
