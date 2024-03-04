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
    public function Website(Request $request, $id_nhaMay){
        $account = account::where('id_nhaMay',$id_nhaMay)->first();
        $request->session()->put('name_account', $account->name_account);
        $request->session()->put('pass_account', $account->pass_account);
        $request->session()->put('id_nhaMay', $id_nhaMay);
        return Redirect::to('User/'.$id_nhaMay);
    }
    public function index()
    {
    	$data = nhaMay::all();
    	$nhaMay = nhaMay::orderby('id_nhaMay')->get();
    	return view('nhaMay.index')->with(compact('data','nhaMay'));
    }
    public function insert()
    {
    	return view('nhaMay.insert');
    }
    public function postinsert(Request $request)
    {
    	$validator = Validator::make(
		    $request->all(),
		    ['name_nhaMay' => 'required|min:1|max:100'],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = nhaMay::where('name_nhaMay',$request->name_nhaMay)->count();
	    	if ($count==0) {
		    	$insert = new nhaMay();
		    	$insert->name_nhaMay = $request->name_nhaMay;
		    	$insert->link_map = $request->link_map;
		    	$insert->save();
		    	return Redirect::to('Admin/nhaMay');
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function update($id_nhaMay)
    {
    	$data = nhaMay::find($id_nhaMay);
    	return view('nhaMay.update')->with(compact('data'));
    }
     public function postupdate(Request $request, $id_nhaMay)
    {
    	$validator = Validator::make(
		    $request->all(),
		    ['name_nhaMay' => 'required|min:1|max:100'],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = nhaMay::where('name_nhaMay',$request->name_nhaMay)->where('id_nhaMay','!=',$id_nhaMay)->count();
	    	if ($count==0) {
		    	$update = nhaMay::find($id_nhaMay);
		    	$update->name_nhaMay = $request->name_nhaMay;
		    	$update->link_map = $request->link_map;
		    	$update->save();
		    	return Redirect::to('Admin/nhaMay');
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_nhaMay)
    {
    	$data = nhaMay::find($id_nhaMay);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
