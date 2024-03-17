<?php
// ok
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\khuVuc;
use App\alert;

class alertController extends Controller
{
    public function index($id_khuVuc)
    {
    	$khuVuc = khuVuc::find($id_khuVuc);
    	$name = $khuVuc->name_khuVuc;
    	$id_nhaMay = $khuVuc->id_nhaMay;
	    $data = alert::where('id_khuVuc', $id_khuVuc)->orderBy('id_alert')->get();
	    return view('alert.index', compact('data', 'id_khuVuc', 'id_nhaMay' ,'name'));
    }
    public function insert($id_khuVuc)
    {
    	return view('alert.insert', compact('id_khuVuc'));
    }
    public function postinsert(Request $request, $id_khuVuc)
    {
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
	    	$count = alert::where('name_alert',$request->name_alert)->where('id_khuVuc',$id_khuVuc)->count();
	    	if ($count==0) {
		    	$insert = new alert();
		    	$insert->id_khuVuc = $id_khuVuc;
		    	$insert->name_alert = $request->name_alert;
		    	$insert->minmin = $request->minmin;
		    	$insert->min = $request->min;
		    	$insert->max = $request->max;
		    	$insert->maxmax = $request->maxmax;
		    	$insert->enable = $request->enable;
		    	$insert->save();
		    	return Redirect::to('Admin/alert/'.$id_khuVuc);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function update($id_alert)
    {
    	$data = alert::find($id_alert);
    	return view('alert.update')->with(compact('data'));
    }
     public function postupdate(Request $request, $id_alert)
    {
		$validator = Validator::make(
		    $request->all(),
		    [
		    	'id_khuVuc' => 'required',
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
	    	$count = alert::where('name_alert',$request->name_alert)->where('id_khuVuc',$request->id_khuVuc)->where('id_alert','!=',$id_alert)->count();
	    	if ($count==0) {
		    	$update = alert::find($id_alert);
		    	$update->name_alert = $request->name_alert;
		    	$update->minmin = $request->minmin;
		    	$update->min = $request->min;
		    	$update->max = $request->max;
		    	$update->maxmax = $request->maxmax;
		    	$update->enable = $request->enable;
		    	$update->save();
		    	return Redirect::to('Admin/alert/'.$request->id_khuVuc);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_alert)
    {
    	$data = alert::find($id_alert);
    	$data->delete();
        return Redirect()->back()->withInput();
    }

}
