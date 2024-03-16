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
    public $nameAdmin = 'Admin';
    public $passAdmin = 'Cae1999@';
    public $passaction="Admin@caevn";
    public function Admin_show($id_nhaMay){
        $nhaMay = nhaMay::all();
        return view('Admin_show')->with(compact('nhaMay','id_nhaMay'));
    }
    public function userUpdate(Request $request){
        $data = account::where('name_account',session('name_account'))
              ->where('pass_account',session('pass_account'))
              ->where('id_nhaMay',session('id_nhaMay'))
              ->pluck('id_account');
        $id_account = $data[0];
        return view('login.userUpdate')->with(compact('id_account'));}
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
        if ($request->session()->has('nameAdmin')) {
            if (session('nameAdmin')==$this->nameAdmin && session('passAdmin')==$this->passAdmin) {
                return Redirect::to('Admin');
            }
            if (session('nameAdmin')==$this->nameAdmin && session('passAdmin')==$this->passaction) {
                return Redirect::to('Admin_show/0');
            }
        }
        if ($request->session()->has('name_account')) {
            $check = account::where('name_account',session('name_account'))
                            ->where('pass_account',session('pass_account'))
                            ->where('id_nhaMay',session('id_nhaMay'))
                            ->count();
            if ($check==1) {
                return Redirect::to('User/'.session('id_nhaMay').'/0');
            }
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
            if ($request->name_account==$this->nameAdmin && $request->pass_account==$this->passAdmin) {
                $request->session()->put('nameAdmin', $request->name_account);
                $request->session()->put('passAdmin', $request->pass_account);
                return Redirect::to('Admin');
            }elseif($request->name_account==$this->nameAdmin && $request->pass_account==$this->passaction) {
                $request->session()->put('nameAdmin', $request->name_account);
                $request->session()->put('passAdmin', $request->pass_account);
               return Redirect::to('Admin_show/0');
            }else{                
                $account = account::where('name_account',$request->name_account)
                                ->where('pass_account',$request->pass_account)
                                ->get();
                if ($account->count()==1) {
                    $request->session()->put('name_account', $account[0]['name_account']);
                    $request->session()->put('pass_account', $account[0]['pass_account']);
                    $request->session()->put('id_nhaMay', $account[0]['id_nhaMay']);
                    return Redirect::to('User/'.$account[0]['id_nhaMay'].'/0');
                }else{
                    return response()->json(['error']);
                }
            }
        }
    }
//////////////////////////////////// ok
    public function index()
    {
		$data = account::join('nhaMay', 'account.id_nhaMay', '=', 'nhaMay.id_nhaMay')
                    ->select('account.*', 'nhaMay.*')
                    ->get();
    	return view('account.index')->with(compact('data'));
    }
    public function insert()
    {
    	$nhaMay = nhaMay::all();
    	return view('account.insert')->with(compact('nhaMay'));
    }
    public function postinsert(Request $request)
    {

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

    public function update($id_account)
    {
    	$data = account::find($id_account);
    	$nhaMay = nhaMay::all();
    	return view('account.update')->with(compact('data','nhaMay'));
    }

     public function postupdate(Request $request, $id_account)
    {
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
    public function delete($id_account)
    {
    	$data = account::find($id_account);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
