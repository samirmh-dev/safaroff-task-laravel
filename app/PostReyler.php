<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReyler extends Model
{
	protected $table='post_reyler';

	public function rey_yazan(){
		return $this->belongsTo('App\User','fk_user_id');
	}

	public function post(){
		return $this->belongsTo('App\PostModel','fk_post_id');
	}

	public function content() {
		return $this->hasOne('App\PostReylerContent','fk_rey_id');
	}
}
