<?php
// xong
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhaMay;
use App\account;

class nhaMayController extends Controller
{
    public function show(Request $request, $id_nha_may){
        $nhaMay = nhaMay::all();
        return view('show')->with(compact('nhaMay','id_nha_may'));
    }
    public function index(){
    	$data = nhaMay::all();
    	$nhaMay = nhaMay::orderby('id_nha_may')->get();
    	return view('nhaMay.index')->with(compact('data','nhaMay'));
    }
    public function insert(){
    	return view('nhaMay.insert');
    }
    public function postinsert(Request $request){
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
		    	return Redirect::to('Admin/nhaMay');
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function update($id_nha_may){
    	$data = nhaMay::find($id_nha_may);
    	return view('nhaMay.update')->with(compact('data'));
    }
    public function postupdate(Request $request, $id_nha_may){
    	$validator = Validator::make(
		    $request->all(),
		    ['name_nha_may' => 'required|min:1|max:100'],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = nhaMay::where('name_nha_may',$request->name_nha_may)->where('id_nha_may','!=',$id_nha_may)->count();
	    	if ($count==0) {
		    	$update = nhaMay::find($id_nha_may);
		    	$update->name_nha_may = $request->name_nha_may;
		    	$update->save();
		    	return Redirect::to('Admin/nhaMay');
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_nha_may){
    	$data = nhaMay::find($id_nha_may);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
