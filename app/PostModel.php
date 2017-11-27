<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
	protected $table='posts';
	protected $fillable=[
		'by_user'
	];
	//sekile muraciet ucun
	public function sekil(){
		return $this->hasOne('App\PostImage','for_post');
	}
	public function link(){
		return $this->hasOne('App\PostLink','for_post');
	}
	public function metn(){
		return $this->hasOne('App\PostMetn','for_post');
	}
	public function title(){
		return $this->hasOne('App\PostTitle','for_post');
	}
	public function postu_yazan(){
		return $this->belongsTo( 'App\User','by_user');
	}

	public function rey(){
		return $this->hasMany('App\PostReyler','fk_post_id');
	}
}
