<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMetn extends Model
{
	protected $table='post_metns';
	protected $fillable=['metn','for_post'];
	public function post(){
		return $this->belongsTo('App\PostModel');
	}
}
