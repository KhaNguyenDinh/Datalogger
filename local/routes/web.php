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

Route::get('Admin_show/{id_nhaMay}', 'accountController@Admin_show');

Route::group(['prefix'=>'User'],function(){

	Route::get('update', 'accountController@userUpdate');
	Route::post('postUpdate/{id_account}', 'accountController@UserPostUpdate');

	Route::get('loadTxtNhaMay/{id_nhaMay}','dulieuTXTController@loadTxtNhaMay');

	Route::get('/{id_nhaMay}', 'dulieuTXTController@showTrangChu');

	Route::get('khuVuc/{id_khuVuc}/{action}', 'dulieuTXTController@showKhuVuc');
	Route::post('postKhuVuc/{id_khuVuc}/{action}', 'dulieuTXTController@postShowKhuVuc');
	// Route::post('postExportExecel/{id_khuVuc}','dulieuTXTController@postExportExecel');
});

// Admin

Route::group(['prefix'=>'Admin'],function(){
	Route::get('/','nhaMayController@index');

    Route::get('loadTxt','dulieuTXTController@loadTxtAll');
    Route::get('resetTxt','dulieuTXTController@resetTxt');

	Route::group(['prefix'=>'nhaMay'],function(){
		Route::get('/','nhaMayController@index');
		Route::get('insert','nhaMayController@insert');
		Route::post('postinsert','nhaMayController@postinsert');
		Route::get('update/{id_nhaMay}','nhaMayController@update');
		Route::post('postupdate/{id_nhaMay}','nhaMayController@postupdate');
		Route::get('delete/{id_nhaMay}','nhaMayController@delete');

		Route::get('show/{id_nhaMay}','nhaMayController@Website');
	});

	Route::group(['prefix'=>'khuVuc'],function(){
		Route::get('/{id_nhaMay}','khuVucController@index');
		Route::get('insert/{id_nhaMay}','khuVucController@insert');
		Route::post('postinsert/{id_nhaMay}','khuVucController@postinsert');
		Route::get('update/{id_khuVuc}','khuVucController@update');
		Route::post('postupdate/{id_khuVuc}','khuVucController@postupdate');
		Route::get('delete/{id_khuVuc}','khuVucController@delete');
	});

	Route::group(['prefix'=>'camera'],function(){
		Route::get('/{id_khuVuc}','cameraController@index');
		Route::get('insert/{id_khuVuc}','cameraController@insert');
		Route::post('postinsert/{id_khuVuc}','cameraController@postinsert');
		Route::get('update/{id_camera}','cameraController@update');
		Route::post('postupdate/{id_camera}','cameraController@postupdate');
		Route::get('delete/{id_camera}','cameraController@delete');
	});

	Route::group(['prefix'=>'alert'],function(){
		Route::get('/{id_khuVuc}','alertController@index');
		Route::get('insert/{id_khuVuc}','alertController@insert');
		Route::post('postinsert/{id_khuVuc}','alertController@postinsert');
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
