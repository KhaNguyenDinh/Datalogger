<?php
// ok
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhamay;
use App\khuvuc;
use App\alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class khuvucController extends Controller
{
    public function index($id_nha_may){
		$nhamayGetId = nhamay::find($id_nha_may);
		$khuvuc = khuvuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();
		$results = [];
		$result_khuvuc=[];
		foreach ($khuvuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$newTxt = DB::table($value->folder_txt)
                ->orderByDesc('time')
                ->first();
			array_push($result_khuvuc,['khuvucGetId'=>$value,'alert'=>$alert,'newTxt'=>$newTxt]);
		}
		$results = array_merge($results,['nhamayGetId'=>$nhamayGetId,'khuvuc'=>$khuvuc,'result_khuvuc'=>$result_khuvuc]);
		// dd($results);
		return view('khuvuc.index', compact('results'));
	}
    public function insert($id_nha_may){
    	return view('khuvuc.insert', compact('id_nha_may'));
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
	    	$count = khuvuc::where('name_khu_vuc',$request->name_khu_vuc)->where('id_nha_may',$id_nha_may)->count();
	    	if ($count==0) {
				$folderPath = 'public/TXT/'.$request->folder_txt; // Đường dẫn tới thư mục cần kiểm tra
				$folderPath_move = 'public/TXT_mov/'.$request->folder_txt;
				$path=0;$path_new=0;
				if (!Storage::exists($folderPath)) { $path=1;}
				if (!Storage::exists($folderPath_move)) { $path_new=1;}	
				
				if ($path==1 && $path_new==1) {
					Storage::makeDirectory($folderPath);
					Storage::makeDirectory($folderPath_move);

			    	$insert = new khuvuc();
			    	$insert->id_nha_may = $id_nha_may;
			    	$insert->name_khu_vuc = $request->name_khu_vuc;
			    	$insert->folder_txt = $request->folder_txt;
			    	$insert->type = $request->type;
			    	$insert->loai = $request->loai;
			    	$insert->link_map = $request->link_map;
			    	$insert->save();
			    	return Redirect::to('Admin/khuvuc/'.$id_nha_may);
				}else{
					return response()->json(['success'=>$request->name.' path/ path_new dang ton tai']);
				}
	    	}else{
	    		return response()->json(['success'=>$request->name.'name_khu_vuc dang ton tai']);
	    	}
        }
    }
    public function update($id_khu_vuc){
    	$data = khuvuc::find($id_khu_vuc);
    	return view('khuvuc.update')->with(compact('data'));
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
	    	$count = khuvuc::where('name_khu_vuc',$request->name_khu_vuc)->where('id_khu_vuc','!=',$id_khu_vuc)->count();
	    	if ($count==0) {
		    	$update = khuvuc::find($id_khu_vuc);
		    	$update->name_khu_vuc = $request->name_khu_vuc;
		    	$update->loai = $request->loai;
		    	$update->link_map = $request->link_map;
		    	$update->save();
		    	return Redirect::to('Admin/khuvuc/'.$request->id_nha_may);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_khu_vuc){
    	$data = khuvuc::find($id_khu_vuc);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
