<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //admin statusunun yoxlanilmasi
	public function isadmin(){
		return $this->isAdmin;
	}

	//posta uygun hemin postu yazan istifadecini elde etmek ucun
	public function post() {
		return $this->hasMany('App\PostModel','for_post');
	}

	public function rey(){
		return $this->hasMany('App\PostReyler','fk_user_id');
	}
}
