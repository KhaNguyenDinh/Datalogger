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
    public function index($id_khu_vuc)
    {
    	$khuVuc = khuVuc::find($id_khu_vuc);
    	$name = $khuVuc->name_khu_vuc;
    	$id_nha_may = $khuVuc->id_nha_may;
	    $data = alert::where('id_khu_vuc', $id_khu_vuc)->orderBy('id_alert')->get();
	    return view('alert.index', compact('data', 'id_khu_vuc', 'id_nha_may' ,'name'));
    }
    public function insert($id_khu_vuc)
    {
    	return view('alert.insert', compact('id_khu_vuc'));
    }
    public function postinsert(Request $request, $id_khu_vuc)
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
		    	return Redirect::to('Admin/alert/'.$id_khu_vuc);
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
		    	'id_khu_vuc' => 'required',
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
	    	$count = alert::where('name_alert',$request->name_alert)->where('id_khu_vuc',$request->id_khu_vuc)->where('id_alert','!=',$id_alert)->count();
	    	if ($count==0) {
		    	$update = alert::find($id_alert);
		    	$update->name_alert = $request->name_alert;
		    	$update->minmin = $request->minmin;
		    	$update->min = $request->min;
		    	$update->max = $request->max;
		    	$update->maxmax = $request->maxmax;
		    	$update->enable = $request->enable;
		    	$update->save();
		    	return Redirect::to('Admin/alert/'.$request->id_khu_vuc);
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
