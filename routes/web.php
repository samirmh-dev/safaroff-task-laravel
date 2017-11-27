<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'IndexController@index')->name('home');

//Admin paneli ucun
Route::group(['prefix' => 'admin',  'middleware' => ['auth','admin']], function() {
	Route::get('/','AdminController@index')->name('admin.index');

	//postlar
	Route::resource( 'post', 'PostController',[
		'names'=>[
			'index'=>'post.bax',
			'create'=>'post.yeni',
			'show'=>'post.goster',
			'destroy'=>'post.sil',
		]
	]);

	//esas sehife
	Route::get('esas-sehife','EsasSehifeController@index')->name('esas-sehife-melumatlari.index');
	Route::post('esas-sehife/update','EsasSehifeController@deyisdir')->name('esas-sehife-melumatlari.deyisdir');

	//sehifeler
	Route::resource( 'sehifeler', 'SehifeController',[
		'except'=>[
			'show'
		]
	]);

	//sosial sebeke unvanlarinin deyisdirilmesi ucun
	Route::get('sosial-sebeke','SosialSebekeController@edit')->name('sosial-sebeke-edit');
	Route::post('sosial-sebeke/update','SosialSebekeController@update')->name('sosial-sebeke-update');

	//istifadeciler
	Route::resource('istifadeciler','UsersController',[
		'only'=>[
			'index','destroy','update'
		]
	]);

	//reylere baxis
	Route::get('reyler','ReyController@baxis')->name('reyler-baxis');
	Route::delete('reyler/{id}','ReyController@sil')->name('reyler-sil');
});

//sehifelere kecid
Route::get('{link}','SehifeController@bax');

//postlara kecid
Route::get('post/{link}','PostController@postakecid')->name( 'postakec');

//Contact bolmesinden mail gondermek ucun
Route::post('mail','IndexController@mail')->name('mail');

//rey bildirmek
Route::post('rey-bildir/{post_id}','ReyController@add')->middleware('auth')->name('rey-bildir');