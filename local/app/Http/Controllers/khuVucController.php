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
	public function newTime($table){
		$results = DB::table($table)
		    	->select('time')
		    	->orderBy('time', 'desc')
		    	->distinct() // loai bo time trung nhau
		    	->limit(1)
		    	->get()
		    	->pluck('time');
		if (count($results)==0) {
			$results='';
		}else{
			$results = $results[0];
		}
		return $results;}
	public function getTxt($table,$time){
		$results = DB::table($table)
			->where('time',$time)->get();
		return $results;
	}
    public function index($id_nhaMay)
    {
 		$results=[];
		$nhaMayGetId = nhaMay::find($id_nhaMay);
		$khuVuc = khuVuc::where('id_nhaMay', $id_nhaMay)->orderBy('id_khuVuc')->get();
		$txt_khuVuc=[];
		foreach ($khuVuc as $key => $value) {
			$table = $value->folder_TXT;
			$id_khuVuc = $value->id_khuVuc;
			// $khuVucGetId = $this->khuVucGetId($id_khuVuc);
			$alert =alert::where('id_khuVuc', $id_khuVuc)->get();
			$newTime = $this->newTime($table);
			if ($newTime!='') {
				$getTxt = $this->getTxt($table,$newTime);
				array_push($txt_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'time'=>$newTime,'getTxt'=>$getTxt]);
			}else{
				array_push($txt_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'time'=>null,'getTxt'=>null]);
			}
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'txt_khuVuc'=>$txt_khuVuc]);
		// dd($results);
		return view('khuVuc.index', compact('results'));
	}

    public function insert($id_nhaMay)
    {
    	return view('khuVuc.insert', compact('id_nhaMay'));
    }

    public function postinsert(Request $request, $id_nhaMay)
    {
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_khuVuc' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'folder_TXT' => 'required|min:1|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
		        'type' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = khuVuc::where('name_khuVuc',$request->name_khuVuc)->where('id_nhaMay',$id_nhaMay)->count();
	    	if ($count==0) {
				$folderPath = 'public/TXT/'.$request->folder_TXT; // Đường dẫn tới thư mục cần kiểm tra
				$folderPath_move = 'public/TXT_mov/'.$request->folder_TXT;
				$path=0;$path_new=0;
				if (!Storage::exists($folderPath)) { $path=1;}
				if (!Storage::exists($folderPath_move)) { $path_new=1;}	
				if ($path==1 && $path_new==1) {
					Storage::makeDirectory($folderPath);
					Storage::makeDirectory($folderPath_move);
			    	$insert = new khuVuc();
			    	$insert->id_nhaMay = $id_nhaMay;
			    	$insert->name_khuVuc = $request->name_khuVuc;
			    	$insert->folder_TXT = $request->folder_TXT;
			    	$insert->type = $request->type;
			    	$insert->save();
			    	return Redirect::to('Admin/khuVuc/'.$id_nhaMay);
				}else{
					return response()->json(['success'=>$request->name.' path/ path_new dang ton tai']);
				}
	    	}else{
	    		return response()->json(['success'=>$request->name.'name_khuVuc dang ton tai']);
	    	}
        }
    }


    public function update($id_khuVuc)
    {
    	$data = khuVuc::find($id_khuVuc);
    	return view('khuVuc.update')->with(compact('data'));
    }
     public function postupdate(Request $request, $id_khuVuc)
    {
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_khuVuc' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'type' => 'required|min:1|max:100'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = khuVuc::where('name_khuVuc',$request->name_khuVuc)->where('id_khuVuc','!=',$id_khuVuc)->count();
	    	if ($count==0) {
		    	$update = khuVuc::find($id_khuVuc);
		    	$update->name_khuVuc = $request->name_khuVuc;
		    	// $update->path = $request->path;
		    	// $update->path_new = $request->path_new;
		    	$update->type = $request->type;
		    	$update->save();
		    	return Redirect::to('Admin/khuVuc/'.$request->id_nhaMay);
		    	// return Redirect()->back();
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_khuVuc)
    {
    	$data = khuVuc::find($id_khuVuc);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
