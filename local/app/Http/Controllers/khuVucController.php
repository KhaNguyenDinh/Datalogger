<?php
// ok
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhaMay;
use App\khuVuc;
use App\alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class khuVucController extends Controller
{
    public function index($id_nha_may){
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();
		$results = [];
		$result_khuVuc=[];
		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$newTxt = DB::table($value->folder_txt)
                ->orderByDesc('time')
                ->first();
			array_push($result_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'newTxt'=>$newTxt]);
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'result_khuVuc'=>$result_khuVuc]);
		// dd($results);
		return view('khuVuc.index', compact('results'));
	}
    public function insert($id_nha_may){
    	return view('khuVuc.insert', compact('id_nha_may'));
    }
    public function postinsert(Request $request, $id_nha_may){
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
			    	return Redirect::to('Admin/khuVuc/'.$id_nha_may);
				}else{
					return response()->json(['success'=>$request->name.' path/ path_new dang ton tai']);
				}
	    	}else{
	    		return response()->json(['success'=>$request->name.'name_khu_vuc dang ton tai']);
	    	}
        }
    }
    public function update($id_khu_vuc){
    	$data = khuVuc::find($id_khu_vuc);
    	return view('khuVuc.update')->with(compact('data'));
    }
    public function postupdate(Request $request, $id_khu_vuc){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_khu_vuc' => 'required|min:1|max:100',
		        'link_map' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = khuVuc::where('name_khu_vuc',$request->name_khu_vuc)->where('id_khu_vuc','!=',$id_khu_vuc)->count();
	    	if ($count==0) {
		    	$update = khuVuc::find($id_khu_vuc);
		    	$update->name_khu_vuc = $request->name_khu_vuc;
		    	$update->loai = $request->loai;
		    	$update->link_map = $request->link_map;
		    	$update->save();
		    	return Redirect::to('Admin/khuVuc/'.$request->id_nha_may);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_khu_vuc){
    	$data = khuVuc::find($id_khu_vuc);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
