<?php

namespace App\Http\Controllers;
use App\Services\CameraService;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\nhaMay;
use App\khuVuc;
use App\alert;
use App\camera;
use App\account;
use App\viTri;
use App\vanPhong;
use App\role;
use App\email;
use DateTime;


class masterController extends Controller
{
    public function mail_index(){
        $data = email::join('nhaMay', 'mail.id_nha_may', '=', 'nhaMay.id_nha_may')
                    ->select('mail.*', 'nhaMay.*')
                    ->orderBy('id','desc')
                    ->get();
        $nhaMay = nhaMay::all();
        return view('Master.mail')->with(compact('data','nhaMay'));
    }
    public function mail_postinsert(Request $request){
        $validator = Validator::make(
            $request->all(),
            ['email' => 'required|min:1|max:100'],
        );
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $count = email::where('email',$request->email)->count();
            if ($count==0) {
                $insert = new email();
                $insert->id_nha_may = $request->id_nha_may;
                $insert->email = $request->email;
                $insert->save();
                return Redirect()->back()->withInput();
            }else{
                return response()->json(['success'=>$request->email.' dang ton tai']);
            }
        }
    }
    public function mail_postupdate(Request $request){
        for ($i=0; $i < count($request->id) ; $i++) { 
            $count = email::where('email',$request->email[$i])
                        ->where('id','!=',$request->id[$i])->count();
            if ($count==0) {
                $update = email::find($request->id[$i]);
                $update->email = $request->email[$i];
                $update->id_nha_may = $request->id_nha_may[$i];
                $update->save();
            }else{
                return response()->json(['success'=>$request->email[$i].' dang ton tai']);
            }
        }
        return Redirect()->back()->withInput();
    }
    public function mail_delete($id){
        $data = email::find($id)->delete();
        return Redirect()->back()->withInput();
    }



    public function resetTxt(){
        $khuVucAll = khuVuc::all();
        foreach ($khuVucAll as $key => $khuVuc) {
            $count = DB::table($khuVuc->folder_txt)->count();
            if ($count>25920) {
                DB::table($khuVuc->folder_txt)
                ->orderByDesc('time')
                ->skip(25920) // Bỏ qua 25920 bản ghi đầu tiên (3 tháng)
                ->pluck('time')
                ->each(function ($time) use ($khuVuc) {
                    DB::table($khuVuc->folder_txt)
                        ->where('time', $time)
                        ->delete();
                });
            }
        }
        return Redirect()->back()->withInput();
    } //ok
    public function show(Request $request, $id_nha_may){
        $nhaMay = nhaMay::all();
        return view('Master.show')->with(compact('nhaMay','id_nha_may'));
    }
    // nha may
    public function nhamay_index(){
    	$data = nhaMay::orderby('id_nha_may','desc')->get();
    	return view('Master.nhaMay')->with(compact('data'));
    }
    public function nhamay_postinsert(Request $request){
    	$validator = Validator::make(
		    $request->all(),
		    ['name_nha_may' => 'required|min:1|max:100'],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = nhaMay::where('name_nha_may',$request->name_nha_may)->count();
	    	if ($count==0) {
		    	$insert = new nhaMay();
		    	$insert->name_nha_may = $request->name_nha_may;
		    	$insert->save();
                return Redirect()->back()->withInput();
	    	}else{
	    		return response()->json(['success'=>$request->name_nha_may.' dang ton tai']);
	    	}
        }
    }
    public function nhamay_postupdate(Request $request){
        for ($i=0; $i < count($request->id_nha_may) ; $i++) { 
            $count = nhaMay::where('name_nha_may',$request->name_nha_may[$i])->where('id_nha_may','!=',$request->id_nha_may[$i])->count();
            if ($count==0) {
                $update = nhaMay::find($request->id_nha_may[$i]);
                $update->name_nha_may = $request->name_nha_may[$i];
                $update->save();
            }else{
                return response()->json(['success'=>$request->name_nha_may[$i].' dang ton tai']);
            }
        }
        return Redirect()->back()->withInput();
    }
    public function nhamay_delete($id_nha_may){
    	$data = nhaMay::find($id_nha_may)->delete();
        return Redirect()->back()->withInput();
    }
    // van phong
    public function vanphong_index(){
        $data = vanPhong::orderby('id_van_phong','desc')->get();
        $account = account::where('level','office')->get();
        return view('Master.vanPhong')->with(compact('data','account'));
    }
    public function vanphong_postinsert(Request $request){
        $validator = Validator::make(
            $request->all(),
            ['name_van_phong' => 'required|min:1|max:100'],
        );
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $count = vanPhong::where('name_van_phong',$request->name_van_phong)
                            ->orWhere('id_account', $request->id_account)
                            ->count();
            if ($count==0) {
                $insert = new vanPhong();
                $insert->name_van_phong = $request->name_van_phong;
                $insert->id_account = $request->id_account;
                $insert->save();
                return Redirect()->back()->withInput();
            }else{
                return response()->json(['success'=>$request->name_van_phong.' | account dang ton tai']);
            }
        }
    }
    public function vanphong_postupdate(Request $request){
        for ($i=0; $i < count($request->id_van_phong) ; $i++) { 
            $count = vanPhong::where('name_van_phong',$request->name_van_phong[$i])
                                ->orWhere('id_account', $request->id_account[$i])
                                ->where('id_van_phong','!=',$request->id_van_phong[$i])->count();
            if ($count==0) {
                $update = vanPhong::find($request->id_van_phong[$i]);
                $update->name_van_phong = $request->name_van_phong[$i];
                $update->id_account = $request->id_account[$i];
                $update->save();
            }else{
                return response()->json(['success'=>$request->name_van_phong[$i].'| account dang ton tai']);
            }
        }
        return Redirect()->back()->withInput();
    }
    public function vanphong_delete($id_van_phong){
        $data = vanPhong::find($id_van_phong)->delete();
        return Redirect()->back()->withInput();
    }
    // role
    public function role_index(){
        $role = role::orderby('id','desc')->get();
        $nhaMay = nhaMay::all();
        $vanPhong = vanPhong::all();
        return view('Master.role')->with(compact('role','nhaMay','vanPhong'));
    }
    public function role_postinsert(Request $request){
        $count = role::where('id_nha_may',$request->id_nha_may)->count();
        if ($count==0) {
            $insert = new role();
            $insert->id_van_phong = $request->id_van_phong;
            $insert->id_nha_may = $request->id_nha_may;
            $insert->save();
            return Redirect()->back()->withInput();
        }else{
            return response()->json(['success'=>'nha may dang ton tai']);
        }
    }
    public function role_postupdate(Request $request){
        for ($i=0; $i < count($request->id) ; $i++) { 
            $count = role::where('id_nha_may',$request->id_nha_may[$i])->where('id','!=',$request->id[$i])->count();
            if ($count==0) {
                $update = role::find($request->id[$i]);
                $update->id_van_phong = $request->id_van_phong[$i];
                $update->id_nha_may = $request->id_nha_may[$i];
                $update->save();
            }else{
                return response()->json(['success'=>' dang ton tai']);
            }
        }
        return Redirect()->back()->withInput();
    }
    public function role_delete($id){
        $data = role::find($id)->delete();
        return Redirect()->back()->withInput();
    }
    // khu vuc
    public function khuvuc_index($id_nha_may){
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc','desc')->get();
		return view('Master.khuVuc', compact('khuVuc','nhaMayGetId'));
	}
    public function khuvuc_postinsert(Request $request, $id_nha_may){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_khu_vuc' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'folder_txt' => 'required|min:1|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
		        'link_map' =>'required',

		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = khuVuc::where('name_khu_vuc',strtolower($request->name_khu_vuc) )->where('id_nha_may',$id_nha_may)->count();
	    	if ($count==0) {
				$folderPath = 'public/TXT/'.strtolower($request->folder_txt); // Đường dẫn tới thư mục cần kiểm tra
				$folderPath_move = 'public/TXT_mov/'.strtolower($request->folder_txt);
				$path=0;$path_new=0;
				if (!Storage::exists($folderPath)) { $path=1;}
				if (!Storage::exists($folderPath_move)) { $path_new=1;}	
				
				if ($path==1 && $path_new==1) {
					Storage::makeDirectory($folderPath);
					Storage::makeDirectory($folderPath_move);

			    	$insert = new khuVuc();
			    	$insert->id_nha_may = $id_nha_may;
			    	$insert->name_khu_vuc = $request->name_khu_vuc;
			    	$insert->folder_txt = strtolower($request->folder_txt);
			    	$insert->type = $request->type;
			    	$insert->loai = $request->loai;
			    	$insert->link_map = $request->link_map;
			    	$insert->save();
			    	return Redirect()->back()->withInput();
				}else{
					return response()->json(['success'=>$request->name.' path/ path_new dang ton tai']);
				}
	    	}else{
	    		return response()->json(['success'=>$request->name.'name_khu_vuc dang ton tai']);
	    	}
        }
    }
    public function khuvuc_postupdate(Request $request, $id_nha_may){
    	for ($i=0; $i < count($request->id_khu_vuc) ; $i++) { 
	    	$count = khuVuc::where('name_khu_vuc',$request->name_khu_vuc[$i])->where('id_khu_vuc','!=',$request->id_khu_vuc[$i])->count();
	    	if ($count==0) {
		    	$update = khuVuc::find($request->id_khu_vuc[$i]);
		    	$update->name_khu_vuc = $request->name_khu_vuc[$i];
		    	$update->type = $request->type[$i];
		    	$update->loai = $request->loai[$i];
		    	$update->link_map = $request->link_map[$i];
		    	$update->save();
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
    	}
    	return Redirect()->back()->withInput();
    }
    public function khuvuc_delete($id_khu_vuc){
    	$data = khuVuc::find($id_khu_vuc)->delete();
        return Redirect()->back()->withInput();
    }
	////// account
    public function account_index(){
		$data = account::join('nhaMay', 'account.id_nha_may', '=', 'nhaMay.id_nha_may')
                    ->select('account.*', 'nhaMay.*')
                    ->where('level','!=','Master')
                    ->orderBy('id_account','desc')
                    ->get();
        $nhaMay = nhaMay::all();
    	return view('Master.account')->with(compact('data','nhaMay'));
    }
    public function account_postinsert(Request $request){
    	$validator = Validator::make(
		    $request->all(),
		    ['name_account' => 'required|min:1|max:100',
		    'pass_account' => 'required|min:1|max:100'
			],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = account::where('name_account',$request->name_account)->count();
	    	if ($count==0) {
		    	$insert = new account();
		    	$insert->id_nha_may = $request->id_nha_may;
		    	$insert->name_account = $request->name_account;
		    	$insert->pass_account = md5($request->pass_account);
                $insert->level = $request->level;
		    	$insert->save();
		    	return Redirect()->back()->withInput();
	    	}else{
	    		return response()->json(['success'=>$request->name_account.' dang ton tai']);
	    	}
        }
    }
    public function account_postupdate(Request $request){
        for ($i=0; $i < count($request->id_account) ; $i++) { 
            $count = account::where('name_account',$request->name_account[$i])
                        ->where('id_account','!=',$request->id_account[$i])->count();
            if ($count==0) {
                $update = account::find($request->id_account[$i]);
                $update->name_account = $request->name_account[$i];
                if ($update->pass_account!==$request->pass_account[$i]) {
                    $update->pass_account = md5($request->pass_account[$i]);
                }
                $update->id_nha_may = $request->id_nha_may[$i];
                $update->level = $request->level[$i];
                $update->save();
            }else{
                return response()->json(['success'=>$request->name_account[$i].' dang ton tai']);
            }
        }
        return Redirect()->back()->withInput();
    }
    public function account_delete($id_account){
    	$data = account::find($id_account)->delete();
        return Redirect()->back()->withInput();
    }
    //// alert
    public function alert_index($id_khu_vuc){
    	$khuVuc = khuVuc::find($id_khu_vuc);
    	$name = $khuVuc->name_khu_vuc;
    	$id_nha_may = $khuVuc->id_nha_may;
	    $data = alert::where('id_khu_vuc', $id_khu_vuc)->orderBy('id_alert','desc')->get();
	    return view('Master.alert', compact('data', 'id_khu_vuc', 'id_nha_may' ,'name'));
    }
    public function alert_postinsert(Request $request, $id_khu_vuc){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_alert' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'minmin' => 'required',
		        'min' => 'required',
		        'max' => 'required',
		        'maxmax' => 'required',
		        'enable' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = alert::where('name_alert',$request->name_alert)->where('id_khu_vuc',$id_khu_vuc)->count();
	    	if ($count==0) {
		    	$insert = new alert();
		    	$insert->id_khu_vuc = $id_khu_vuc;
		    	$insert->name_alert = $request->name_alert;
		    	$insert->minmin = $request->minmin;
		    	$insert->min = $request->min;
		    	$insert->max = $request->max;
		    	$insert->maxmax = $request->maxmax;
		    	$insert->enable = $request->enable;
		    	$insert->save();
		    	return Redirect()->back()->withInput();
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function alert_postupdate(Request $request,$id_khu_vuc){
        for ($i=0; $i < count($request->id_alert) ; $i++) { 
	    	$count = alert::where('name_alert',$request->name_alert[$i])->where('id_khu_vuc',$id_khu_vuc)->where('id_alert','!=',$request->id_alert[$i])->count();
	    	if ($count==0) {
		    	$update = alert::find($request->id_alert[$i]);
		    	$update->name_alert = $request->name_alert[$i];
		    	$update->minmin = $request->minmin[$i];
		    	$update->min = $request->min[$i];
		    	$update->max = $request->max[$i];
		    	$update->maxmax = $request->maxmax[$i];
		    	$update->enable = $request->enable[$i];
		    	$update->save();
	    	}else{
	    		return response()->json(['success'=>$request->name_alert[$i].' dang ton tai']);
	    	}
        }
        return Redirect()->back()->withInput();
    }
    public function alert_delete($id_alert){
    	$data = alert::find($id_alert)->delete();
        return Redirect()->back()->withInput();
    }
    //. camera
    protected $cameraService;

    public function __construct(CameraService $cameraService)
    {
        $this->cameraService = $cameraService;
    }
    public function camera_index($id_khu_vuc){
    	$khuVuc = khuVuc::find($id_khu_vuc);
    	$name = $khuVuc->name_khu_vuc;
    	$id_nha_may = $khuVuc->id_nha_may;
	    $data = camera::where('id_khu_vuc', $id_khu_vuc)->orderBy('id_camera','desc')->get();
	    return view('Master.camera', compact('data', 'id_khu_vuc', 'id_nha_may' ,'name'));
    }
    public function camera_postinsert(Request $request, $id_khu_vuc){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_camera' => 'required|min:1|max:100',
		        'link_rtsp' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $count = camera::where('name_camera',$request->name_camera)->count();
            if ($count==0) {
                $insert = new camera();
                $insert->id_khu_vuc = $id_khu_vuc;
                $insert->name_camera = $request->name_camera;
                $insert->link_rtsp = $request->link_rtsp;
                $this->cameraService->create([
                    'name' => $request->name_camera,
                    'link' => $request->link_rtsp
                ]);
                $insert->save();
                return Redirect()->back()->withInput();
            }else{
                return response()->json(['success'=>$request->name_camera.' dang ton tai']);
            }
        }
    }
    public function camera_postupdate(Request $request, $id_khu_vuc){
        for ($i=0; $i < count($request->id_camera) ; $i++) { 
            $count = camera::where('name_camera',$request->name_camera[$i])->where('id_camera','!=',$request->id_camera[$i])->count();
            if ($count==0) {
                $update = camera::query()->where('id_camera', $request->id_camera[$i])->firstOrFail();
                $this->cameraService->update($update->name_camera, [
                    'name' => $request->name_camera[$i],
                    'link' => $request->link_rtsp[$i]
                ]);
                $update->name_camera = $request->name_camera[$i];
                $update->link_rtsp = $request->link_rtsp[$i];
                $update->save();
            }else{
                return response()->json(['success'=>$request->name_camera[$i].' dang ton tai']);
            }
        }
        return Redirect()->back()->withInput();
    }
    public function camera_delete($id_camera){
    	$data = camera::query()->where('id_camera', $id_camera)->firstOrFail()->delete();
        // $name = ['demo','io','nguyen'];
        // foreach ($name as $key => $value) {
        //     $this->cameraService->delete($value);
        // }
        return Redirect()->back()->withInput();
    }
    // vi tri
    public function vitri_index($id_khu_vuc){
    	$khuVuc = khuVuc::find($id_khu_vuc);
	    $data = viTri::where('id_khu_vuc', $id_khu_vuc)->orderBy('vitri','asc')->get();
	    return view('Master.viTri', compact('data', 'khuVuc'));
    }
    public function vitri_postinsert(Request $request, $id_khu_vuc){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'vitri' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = viTri::where('name',$request->name)->where('id_khu_vuc',$id_khu_vuc)->count();
	    	if ($count==0) {
		    	$insert = new viTri();
		    	$insert->id_khu_vuc = $id_khu_vuc;
		    	$insert->name = $request->name;
		    	$insert->vitri = $request->vitri;
		    	$insert->save();
		    	return Redirect()->back()->withInput();
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function vitri_postupdate(Request $request, $id_khu_vuc){
    	 for ($i=0; $i < count($request->id) ; $i++) { 
	    	$count = viTri::where('name',$request->name[$i])->where('id_khu_vuc',$id_khu_vuc)->where('id','!=',$request->id[$i])->count();
	    	if ($count==0) {
		    	$update = viTri::find($request->id[$i]);
		    	$update->name = $request->name[$i];
		    	$update->vitri = $request->vitri[$i];
		    	$update->save();
	    	}else{
	    		return response()->json(['success'=>$request->name[$i].' dang ton tai']);
	    	}
     	}
     	return Redirect()->back()->withInput();
    }
    public function vitri_delete($id){
    	$data = viTri::find($id)->delete();
        return Redirect()->back()->withInput();
    }
}
