<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
	protected $table='post_images';
	protected $fillable=['sekil','for_post'];
	public function post(){
		return $this->belongsTo('App\PostModel');
	}
}
