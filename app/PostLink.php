<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLink extends Model
{
	protected $table='post_links';
	protected $fillable=['link','for_post'];
	public function post(){
		return $this->belongsTo('App\PostModel');
	}
}
