<?php
// ok
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\khuVuc;
use App\viTri;

class vitriController extends Controller
{
    public function index($id_khu_vuc)
    {
    	$khuVuc = khuVuc::find($id_khu_vuc);
    	$name = $khuVuc->name_khu_vuc;
    	$id_nha_may = $khuVuc->id_nha_may;
	    $data = viTri::where('id_khu_vuc', $id_khu_vuc)->orderBy('id')->get();
	    return view('viTri.index', compact('data', 'id_khu_vuc', 'id_nha_may' ,'name'));
    }
    public function insert($id_khu_vuc)
    {
    	return view('viTri.insert', compact('id_khu_vuc'));
    }
    public function postinsert(Request $request, $id_khu_vuc)
    {
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
		    	return Redirect::to('Admin/viTri/'.$id_khu_vuc);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function update($id)
    {
    	$data = viTri::find($id);
    	return view('viTri.update')->with(compact('data'));
    }
     public function postupdate(Request $request, $id)
    {
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
	    	$count = viTri::where('name',$request->name)->where('id_khu_vuc',$request->id_khu_vuc)->where('id','!=',$id)->count();
	    	if ($count==0) {
		    	$update = viTri::find($id);
		    	$update->name = $request->name;
		    	$update->vitri = $request->vitri;
		    	$update->save();
		    	return Redirect::to('Admin/viTri/'.$request->id_khu_vuc);
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id)
    {
    	$data = viTri::find($id);
    	$data->delete();
        return Redirect()->back()->withInput();
    }

}
