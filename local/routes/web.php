<?php

use Illuminate\Support\Facades\Route;

// Route::get('check_email','dulieuTXTController@mail');

Route::group(['prefix'=>'Master','middleware' => 'check-master'],function(){
	
    Route::get('resetTxt','masterController@resetTxt');
    Route::get('show/{id_nha_may}','masterController@show');
    // account
	Route::group(['prefix'=>'account'],function(){
		Route::get('/','masterController@account_index');
		Route::post('postinsert','masterController@account_postinsert');
		Route::post('postupdate','masterController@account_postupdate');
		Route::get('delete/{id_account}','masterController@account_delete');
	}); 
	//mail
	Route::group(['prefix'=>'mail'],function(){
		Route::get('/','masterController@mail_index');
		Route::post('postinsert','masterController@mail_postinsert');
		Route::post('postupdate','masterController@mail_postupdate');
		Route::get('delete/{id}','masterController@mail_delete');
	}); 
	// nha May
	Route::get('/','masterController@nhamay_index');
	Route::group(['prefix'=>'nhaMay'],function(){
		Route::get('/','masterController@nhamay_index');
		Route::post('postinsert','masterController@nhamay_postinsert');
		Route::post('postupdate','masterController@nhamay_postupdate');
		Route::get('delete/{id_nha_may}','masterController@nhamay_delete');
	});
	// vanPhong
	Route::group(['prefix'=>'vanPhong'],function(){
		Route::get('/','masterController@vanphong_index');
		Route::post('postinsert','masterController@vanphong_postinsert');
		Route::post('postupdate','masterController@vanphong_postupdate');
		Route::get('delete/{id_van_phong}','masterController@vanphong_delete');
	});
	// role
	Route::group(['prefix'=>'role'],function(){
		Route::get('/','masterController@role_index');
		Route::post('postinsert','masterController@role_postinsert');
		Route::post('postupdate','masterController@role_postupdate');
		Route::get('delete/{id}','masterController@role_delete');
	});
	// khu vuc
	Route::group(['prefix'=>'khuVuc'],function(){
		Route::get('/{id_nha_may}','masterController@khuvuc_index');
		Route::post('postinsert/{id_nha_may}','masterController@khuvuc_postinsert');
		Route::post('postupdate/{id_nha_may}','masterController@khuvuc_postupdate');
		Route::get('delete/{id_khu_vuc}','masterController@khuvuc_delete');
	});
	// camera
	Route::group(['prefix'=>'camera'],function(){
		Route::get('/{id_khu_vuc}','masterController@camera_index');
		Route::post('postinsert/{id_khu_vuc}','masterController@camera_postinsert');
		Route::post('postupdate/{id_khu_vuc}','masterController@camera_postupdate');
		Route::get('delete/{id_camera}','masterController@camera_delete');
	});
	// alert
	Route::group(['prefix'=>'alert'],function(){
		Route::get('/{id_khu_vuc}','masterController@alert_index');
		Route::post('postinsert/{id_khu_vuc}','masterController@alert_postinsert');
		Route::post('postupdate/{id_khu_vuc}','masterController@alert_postupdate');
		Route::get('delete/{id_alert}','masterController@alert_delete');
	});
	// vi tri
	Route::group(['prefix'=>'viTri'],function(){
		Route::get('/{id_khu_vuc}','masterController@vitri_index');
		Route::post('postinsert/{id_khu_vuc}','masterController@vitri_postinsert');
		Route::post('postupdate/{id_khu_vuc}','masterController@vitri_postupdate');
		Route::get('delete/{id}','masterController@vitri_delete');
	});

});//OK
Route::group(['prefix'=>'User','middleware' => 'check-account'],function(){
	//alert
	Route::get('alert_delete/{id_alert}','viewController@alert_delete');
	Route::post('alert_postinsert/{id_khu_vuc}','viewController@alert_postinsert');
	Route::post('alert_postupdate/{id_khu_vuc}','viewController@alert_postupdate');
	//user
	Route::get('user_update', 'viewController@user_update');
	Route::post('user_postUpdate/{id_account}', 'viewController@user_postUpdate');
	// view
	Route::get('/{id_nha_may}/{key_view}', 'viewController@showTrangChu');
	Route::get('khuVuc/{id_khu_vuc}/{action}', 'viewController@showKhuVuc');
	Route::post('postKhuVuc/{id_khu_vuc}/{action}', 'viewController@postShowKhuVuc');
});// ok

Route::group(['prefix'=>'Admin','middleware' => 'check-admin'],function(){
	Route::get('/','viewController@admin_home');
});// ok
Route::group(['prefix'=>'vanPhong','middleware' => 'check-vanPhong'],function(){
	Route::get('/{id_van_phong}/{id_nha_may}','viewController@vanphong_home');
});// ok
// login
// Route::get('/', 'viewController@admin');

Route::get('/', 'loginController@login');
Route::post('postLogin','loginController@postLogin');
Route::get('logout', 'loginController@logout');
// relay
Route::get('relay/{id_nha_may}','dulieuTXTController@relay');
//check txt
Route::get('/check-data/{id}', 'dulieuTXTController@checkData')->name('checkData');






