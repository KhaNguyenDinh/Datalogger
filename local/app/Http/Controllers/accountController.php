<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhaMay;
use App\account;
use Illuminate\Support\Facades\Hash;

class accountController extends Controller
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
    //////////// User
    public function userUpdate(Request $request){
        $data = account::where('name_account',session('name_account'))
              ->where('pass_account',session('pass_account'))
              ->where('id_nhaMay',session('id_nhaMay'))
              ->pluck('id_account');
        $id_account = $data[0];
        return view('login.userUpdate')->with(compact('id_account'));
    }
    public function UserPostUpdate(Request $request, $id_account){
        $data = account::find($id_account);
        $validator = Validator::make(
            $request->all(),
            ['new_name_account' => 'required|min:1|max:100',
            'pass_account' => 'required|min:1|max:100',
            'new_pass_account' => 'required|min:1|max:100'
            ],
        );
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $count = account::where('name_account',$request->new_name_account)
                            ->where('pass_account',$request->new_pass_account)
                        ->where('id_account','!=',$id_account)->count();
            if ( ($count==0) && ($request->pass_account==$data->pass_account) ) {
                $update = account::find($id_account);
                $update->name_account = $request->new_name_account;
                $update->pass_account = $request->new_pass_account;
                $update->save();

                $request->session()->put('name_account', $request->new_name_account);
                $request->session()->put('pass_account', $request->new_pass_account);
                return Redirect::to('/');
            }else{
                return response()->json(['success'=>$request->name_account.' dang ton tai']);
            }
        }
    }
    public function logout(Request $request){
        $request->session()->flush();
       return Redirect::to('/');
    }

    public function login(Request $request){
        if ($request->session()->has('nameMaster')) {
            if (session('nameMaster')==$this->nameMaster && session('passMaster')==$this->passMaster) {
                return Redirect::to('Admin');
            }
        }
        if ($request->session()->has('nameAdmin')) {
            if (session('nameAdmin')==$this->nameAdmin && session('passAdmin')==$this->passAdmin) {
                return Redirect::to('Admin/show/0');
            }
        }
        if ($request->session()->has('name_account')) {

            $count = account::where('name_account',session('name_account'))
                            ->where('pass_account',session('pass_account'))
                            ->count();
            if ($count==1) {return Redirect::to('User/'.session('id_nhaMay').'/0');}
        }
        return view('login.index');
    }
    public function postLogin(Request $request){
        $validator = Validator::make(
            $request->all(),
            ['name_account' => 'required|min:1|max:100',
            'pass_account' => 'required|min:1|max:100'
            ],
        );
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            if ($request->name_account==$this->nameMaster && $request->pass_account==$this->passMaster) {
                $request->session()->put('nameMaster', $request->name_account);
                $request->session()->put('passMaster', $request->pass_account);
                return Redirect::to('Admin');
            }elseif($request->name_account==$this->nameAdmin && $request->pass_account==$this->passAdmin) {
                $request->session()->put('nameAdmin', $request->name_account);
                $request->session()->put('passAdmin', $request->pass_account);
               return Redirect::to('Admin/show/0');
            }else{                
                $account = account::where('name_account',$request->name_account)
                                ->where('pass_account',$request->pass_account)
                                ->first();
                if ($account) {
                    $request->session()->put('name_account', $account['name_account']);
                    $request->session()->put('pass_account', $account['pass_account']);
                    $request->session()->put('id_nhaMay', $account['id_nhaMay']);
                    $request->session()->put('level', $account['level']);
                    return Redirect::to('User/'.$account['id_nhaMay'].'/0');
                }else{
                    return response()->json(['error']);
                }
            }
        }
    }
//////////////////////////////////// Admin

    public function index(){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

		$data = account::join('nhaMay', 'account.id_nhaMay', '=', 'nhaMay.id_nhaMay')
                    ->select('account.*', 'nhaMay.*')
                    ->get();
    	return view('account.index')->with(compact('data'));
    }
    public function insert(){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}
        
    	$nhaMay = nhaMay::all();
    	return view('account.insert')->with(compact('nhaMay'));
    }
    public function postinsert(Request $request){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$validator = Validator::make(
		    $request->all(),
		    ['name_account' => 'required|min:1|max:100',
		    'pass_account' => 'required|min:1|max:100'
			],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = account::where('name_account',$request->name_account)->count();
	    	if ($count==0) {
		    	$insert = new account();
		    	$insert->id_nhaMay = $request->id_nhaMay;
		    	$insert->name_account = $request->name_account;
		    	$insert->pass_account = $request->pass_account;
                $insert->level = $request->level;
		    	$insert->save();
		    	return Redirect::to('Admin/account');
	    	}else{
	    		return response()->json(['success'=>$request->name_account.' dang ton tai']);
	    	}
        }
    }
    public function update($id_account){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = account::find($id_account);
    	$nhaMay = nhaMay::all();
    	return view('account.update')->with(compact('data','nhaMay'));
    }
    public function postupdate(Request $request, $id_account){
    	$validator = Validator::make(
		    $request->all(),
		    ['name_account' => 'required|min:1|max:100',
		    'pass_account' => 'required|min:1|max:100'
			],
    	);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$count = account::where('name_account',$request->name_account)
	    				->where('id_account','!=',$id_account)->count();
	    	if ($count==0) {
		    	$update = account::find($id_account);
		    	$update->name_account = $request->name_account;
		    	$update->pass_account = $request->pass_account;
		    	$update->id_nhaMay = $request->id_nhaMay;
                $update->level = $request->level;
		    	$update->save();
		    	return Redirect::to('Admin/account');
	    	}else{
	    		return response()->json(['success'=>$request->name_account.' dang ton tai']);
	    	}
        }
    }
    public function delete($id_account){
        if (session('nameMaster')=='') {return Redirect::to('/');
        }else{ $this->check(session('nameMaster'),session('passMaster'));}

    	$data = account::find($id_account);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
