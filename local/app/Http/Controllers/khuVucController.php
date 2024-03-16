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
    private $nameMaster = 'Master';
    private $passMaster = 'Cae1999@';

    public function check($nameMaster,$passMaster){
        if($nameMaster!=$this->nameMaster || $passMaster!=$this->passMaster) {
            return Redirect::to('/');
        }
    }
///////////////////////////
    public function index($id_nhaMay){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

		$nhaMayGetId = nhaMay::find($id_nhaMay);
		$khuVuc = khuVuc::where('id_nhaMay', $id_nhaMay)->orderBy('id_khuVuc')->get();
		$results = [];
		$result_khuVuc=[];
		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khuVuc', $value->id_khuVuc)->get();
			$newTxt = DB::table($value->folder_TXT)
                ->orderByDesc('time')
                ->first();
			array_push($result_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'newTxt'=>$newTxt]);
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'result_khuVuc'=>$result_khuVuc]);
		// dd($results);
		return view('khuVuc.index', compact('results'));
	}
    public function insert($id_nhaMay){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	return view('khuVuc.insert', compact('id_nhaMay'));
    }
    public function postinsert(Request $request, $id_nhaMay){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_khuVuc' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'folder_TXT' => 'required|min:1|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_]*$/'

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
			    	$insert->nuoc_khi = $request->nuoc_khi;
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
    public function update($id_khuVuc){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = khuVuc::find($id_khuVuc);
    	return view('khuVuc.update')->with(compact('data'));
    }
    public function postupdate(Request $request, $id_khuVuc){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_khuVuc' => 'required|min:1|max:100'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = khuVuc::where('name_khuVuc',$request->name_khuVuc)->where('id_khuVuc','!=',$id_khuVuc)->count();
	    	if ($count==0) {
		    	$update = khuVuc::find($id_khuVuc);
		    	$update->name_khuVuc = $request->name_khuVuc;
		    	$update->type = $request->type;
		    	$insert->nuoc_khi = $request->nuoc_khi;
		    	$update->save();
		    	return Redirect::to('Admin/khuVuc/'.$request->id_nhaMay);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_khuVuc){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = khuVuc::find($id_khuVuc);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
