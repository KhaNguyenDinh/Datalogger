<?php
// xong
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhamay;
use App\account;

class nhamayController extends Controller
{
    public function show(Request $request, $id_nha_may){
        $nhamay = nhamay::all();
        return view('show.index')->with(compact('nhamay','id_nha_may'));
    }
    public function index(){
    	$data = nhamay::all();
    	$nhamay = nhamay::orderby('id_nha_may')->get();
    	return view('nhamay.index')->with(compact('data','nhamay'));
    }
    public function insert(){
    	return view('nhamay.insert');
    }
    public function postinsert(Request $request){
    	$validator = Validator::make(
		    $request->all(),
		    ['name_nha_may' => 'required|min:1|max:100'],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = nhamay::where('name_nha_may',$request->name_nha_may)->count();
	    	if ($count==0) {
		    	$insert = new nhamay();
		    	$insert->name_nha_may = $request->name_nha_may;
		    	$insert->save();
		    	return Redirect::to('Admin/nhamay');
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function update($id_nha_may){
    	$data = nhamay::find($id_nha_may);
    	return view('nhamay.update')->with(compact('data'));
    }
    public function postupdate(Request $request, $id_nha_may){
    	$validator = Validator::make(
		    $request->all(),
		    ['name_nha_may' => 'required|min:1|max:100'],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = nhamay::where('name_nha_may',$request->name_nha_may)->where('id_nha_may','!=',$id_nha_may)->count();
	    	if ($count==0) {
		    	$update = nhamay::find($id_nha_may);
		    	$update->name_nha_may = $request->name_nha_may;
		    	$update->save();
		    	return Redirect::to('Admin/nhamay');
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_nha_may){
    	$data = nhamay::find($id_nha_may);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
