<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTitle extends Model
{
	protected $table='post_titles';
	protected $fillable=['title','title2','for_post'];
	public function post(){
		return $this->belongsTo('App\PostModel');
	}
}
