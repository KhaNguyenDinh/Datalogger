<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'accountController@login');
Route::post('postLogin','accountController@postLogin');
Route::get('logout', 'accountController@logout');

Route::group(['prefix'=>'User','middleware' => 'check-account'],function(){
	Route::get('update', 'accountController@userUpdate');
	Route::post('postUpdate/{id_account}', 'accountController@UserPostUpdate');
	
	Route::get('/{id_nha_may}/{key_view}', 'dulieuTXTController@showTrangChu');
	Route::get('khuvuc/{id_khu_vuc}/{action}', 'dulieuTXTController@showkhuvuc');
	Route::post('postkhuvuc/{id_khu_vuc}/{action}', 'dulieuTXTController@postShowkhuvuc');
});

Route::group(['prefix'=>'Admin','middleware' => 'check-master'],function(){
	
	Route::get('/','nhaMayController@index');

    Route::get('resetTxt','dulieuTXTController@resetTxt');
    Route::get('show/{id_nha_may}','nhaMayController@show');

	Route::group(['prefix'=>'nhamay'],function(){
		Route::get('/','nhaMayController@index');
		Route::get('insert','nhaMayController@insert');
		Route::post('postinsert','nhaMayController@postinsert');
		Route::get('update/{id_nha_may}','nhaMayController@update');
		Route::post('postupdate/{id_nha_may}','nhaMayController@postupdate');
		Route::get('delete/{id_nha_may}','nhaMayController@delete');
	});

	Route::group(['prefix'=>'khuvuc'],function(){
		Route::get('/{id_nha_may}','khuVucController@index');
		Route::get('insert/{id_nha_may}','khuVucController@insert');
		Route::post('postinsert/{id_nha_may}','khuVucController@postinsert');
		Route::get('update/{id_khu_vuc}','khuVucController@update');
		Route::post('postupdate/{id_khu_vuc}','khuVucController@postupdate');
		Route::get('delete/{id_khu_vuc}','khuVucController@delete');
	});

	Route::group(['prefix'=>'camera'],function(){
		Route::get('/{id_khu_vuc}','cameraController@index');
		Route::get('insert/{id_khu_vuc}','cameraController@insert');
		Route::post('postinsert/{id_khu_vuc}','cameraController@postinsert');
		Route::get('update/{id_camera}','cameraController@update');
		Route::post('postupdate/{id_camera}','cameraController@postupdate');
		Route::get('delete/{id_camera}','cameraController@delete');
	});

	Route::group(['prefix'=>'alert'],function(){
		Route::get('/{id_khu_vuc}','alertController@index');
		Route::get('insert/{id_khu_vuc}','alertController@insert');
		Route::post('postinsert/{id_khu_vuc}','alertController@postinsert');
		Route::get('update/{id_alert}','alertController@update');
		Route::post('postupdate/{id_alert}','alertController@postupdate');
		Route::get('delete/{id_alert}','alertController@delete');
	});

	Route::group(['prefix'=>'account'],function(){
		Route::get('/','accountController@index');
		Route::get('insert','accountController@insert');
		Route::post('postinsert','accountController@postinsert');
		Route::get('update/{id_account}','accountController@update');
		Route::post('postupdate/{id_account}','accountController@postupdate');
		Route::get('delete/{id_account}','accountController@delete');
	});
});

Route::group(['prefix'=>'Admin','middleware' => 'check-admin'],function(){
    Route::get('show/{id_nha_may}','nhaMayController@show');
});