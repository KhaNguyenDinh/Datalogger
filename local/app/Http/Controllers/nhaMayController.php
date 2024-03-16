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
    private $nameMaster = 'Master';
    private $passMaster = 'Cae1999@';

    private $nameAdmin = 'Admin';
    private $passAdmin = 'Cae@1999';

    public function check($nameMaster,$passMaster){
        if($nameMaster!=$this->nameMaster || $passMaster!=$this->passMaster) {
            return Redirect::to('/');
        }
    }
    public function show(Request $request, $id_nhaMay){
        if (session('nameMaster')=='' && session('nameAdmin')=='') {return Redirect::to('/');
        }else{
            if (session('nameMaster')!='') {
                if(session('nameMaster')!=$this->nameMaster || session('passMaster')!=$this->passMaster) {
                  return Redirect::to('/');
                }
            }
            if (session('nameAdmin')!='') {
                if(session('nameAdmin')!=$this->nameAdmin || session('passAdmin')!=$this->passAdmin) {
                  return Redirect::to('/');
                }
            }
        }
        if ($id_nhaMay!=0) {
            $account = account::where('id_nhaMay',$id_nhaMay)->first();
            $request->session()->put('name_account', $account->name_account);
            $request->session()->put('pass_account', $account->pass_account);
            $request->session()->put('id_nhaMay', $id_nhaMay);
            $request->session()->put('level', $account['level']);
        }else{
            $request->session()->put('id_nhaMay', 0);
        }
        $nhaMay = nhaMay::all();
        return view('show.index')->with(compact('nhaMay'));
    }
    public function index(){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = nhaMay::all();
    	$nhaMay = nhaMay::orderby('id_nhaMay')->get();
    	return view('nhaMay.index')->with(compact('data','nhaMay'));
    }
    public function insert(){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	return view('nhaMay.insert');
    }
    public function postinsert(Request $request){
        if (session('nameMaster')=='') {return Redirect::to('/');}
        $this->check(session('nameMaster'),session('passMaster'));

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
    public function update($id_nhaMay){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = nhaMay::find($id_nhaMay);
    	return view('nhaMay.update')->with(compact('data'));
    }
    public function postupdate(Request $request, $id_nhaMay){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}
        
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
    public function delete($id_nhaMay){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = nhaMay::find($id_nhaMay);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
