<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	//Admin paneli
	public function index() {
		return view('admin.index');
    }
}
