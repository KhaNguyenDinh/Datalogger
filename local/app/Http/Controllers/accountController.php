<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhaMay;
use App\account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class accountController extends Controller
{
    //////////// User
    public function logout(Request $request){
        $request->session()->flush();
       return Redirect::to('/');
    }
    public function login(Request $request){
        $check = account::where('level','Master')->first();
        if (!$check) {
            $idNhaMayRandom = nhaMay::inRandomOrder()->value('id_nhaMay');
            if ($idNhaMayRandom) {
                $insert = new account();
                $insert->id_nhaMay = $idNhaMayRandom;
                $insert->name_account = 'Master';
                $insert->pass_account = md5('Cae1999@');
                $insert->level = 'Master';
                $insert->save();
            }else{
                $insert = new nhaMay();
                $insert->name_nhaMay = Str::random(6);
                $insert->link_map = Str::random(6);
                $insert->save();
                return Redirect::to('/');
            }
        }
        if ($request->session()->has('level')) {
            switch (session('level')) {
                case 'Master':
                    return Redirect::to('Admin');
                    break;
                case 'Admin':
                    return Redirect::to('Admin/show/0');
                    break;
                default:
                    return Redirect::to('User/'.session('id_nhaMay').'/0');
                    break;
            }
        }else{
            return view('login.index');
        }
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
            $account = account::where('name_account',$request->name_account)
                        ->where('pass_account',md5($request->pass_account))
                        ->first();
            if ($account) {
                $request->session()->put('name_account', $account->name_account);
                $request->session()->put('pass_account', $account->pass_account);
                $request->session()->put('id_nhaMay', $account->id_nhaMay);
                $request->session()->put('level', $account->level);
                switch ($account['level']) {
                    case 'Master':
                        return Redirect::to('Admin');
                        break;
                    case 'Admin':
                        return Redirect::to('Admin/show/0');
                        break;
                    default:
                        return Redirect::to('User/'.$account->id_nhaMay.'/0');
                        break;
                }
            }else{
                return response()->json(['error']);
            }
        }
    }
    public function userUpdate(Request $request){
        $data = account::where('name_account',session('name_account'))
              ->where('pass_account',session('pass_account'))
              ->where('id_nhaMay',session('id_nhaMay'))
              ->first();
        $id_account = $data->id_account;$name_account = $data->name_account;
        return view('login.userUpdate')->with(compact('id_account','name_account'));
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
            if ( ($count==0) && (md5($request->pass_account)==$data->pass_account) ) {
                $update = account::find($id_account);
                $update->name_account = $request->new_name_account;
                $update->pass_account = md5($request->new_pass_account);
                $update->save();

                $request->session()->put('name_account', $request->new_name_account);
                $request->session()->put('pass_account', md5($request->new_pass_account));
                return Redirect::to('/');
            }else{
                return response()->json(['success'=>$request->name_account.' Error']);
            }
        }
    }

//////////////////////////////////// Admin
    public function index(){
		$data = account::join('nhaMay', 'account.id_nhaMay', '=', 'nhaMay.id_nhaMay')
                    ->select('account.*', 'nhaMay.*')
                    ->where('level','!=','Master')
                    ->get();
    	return view('account.index')->with(compact('data'));
    }
    public function insert(){
    	$nhaMay = nhaMay::all();
    	return view('account.insert')->with(compact('nhaMay'));
    }
    public function postinsert(Request $request){
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
		    	$insert->pass_account = md5($request->pass_account);
                $insert->level = $request->level;
		    	$insert->save();
		    	return Redirect::to('Admin/account');
	    	}else{
	    		return response()->json(['success'=>$request->name_account.' dang ton tai']);
	    	}
        }
    }
    public function update($id_account){
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
                if ($update->pass_account!==$request->pass_account) {
                    $update->pass_account = md5($request->pass_account);
                }
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
    	$data = account::find($id_account);
    	$data->delete();
        return Redirect()->back()->withInput();
    }
}
