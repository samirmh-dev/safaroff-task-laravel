<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EsasSehifeMelumatlari extends Model
{
    protected $table='esas_sehife_melumatlari';
    protected $fillable=['ad','melumat'];
}
