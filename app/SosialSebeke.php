<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SosialSebeke extends Model
{
    protected $table='sosial_sebeke';
    protected $fillable=['ad','link'];

	public static function fb() {
		return SosialSebeke::select('link')->where('ad','=','facebook')->get()->first()->toArray()['link'];
    }

	public static function twitter() {
		return SosialSebeke::select('link')->where('ad','=','twitter')->get()->first()->toArray()['link'];
	}

	public static function github() {
		return SosialSebeke::select('link')->where('ad','=','github')->get()->first()->toArray()['link'];
	}

}
