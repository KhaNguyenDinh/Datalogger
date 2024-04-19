<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\nhaMay;
use App\account;
use App\vanPhong;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class loginController extends Controller
{
    public function logout(Request $request){
        $request->session()->flush();
       return Redirect::to('/');
    }
    public function login(Request $request){
        $check = account::where('level','Master')->first();
        if (!$check) {
            $idNhaMayRandom = nhaMay::inRandomOrder()->value('id_nha_may');
            if ($idNhaMayRandom) {
                $insert = new account();
                $insert->id_nha_may = $idNhaMayRandom;
                $insert->name_account = 'Master';
                $insert->pass_account = md5('Cae1999@');
                $insert->level = 'Master';
                $insert->save();
            }else{
                $insert = new nhaMay();
                $insert->name_nha_may = Str::random(6);
                $insert->save();
                return Redirect::to('/');
            }
        }
        if ($request->session()->has('level')) {
            switch (session('level')) {
                case 'Master':
                    return Redirect::to('Master');
                    break;
                case 'Admin':
                    return Redirect::to('Admin');
                    break;
                case 'office':
                    return Redirect::to('vanPhong/'.session('id_van_phong').'/0');
                    break;
                default:
                    return Redirect::to('User/'.session('id_nha_may').'/0');
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
                $request->session()->put('id_account', $account->id_account);
                $request->session()->put('name_account', $account->name_account);
                $request->session()->put('pass_account', $account->pass_account);
                $request->session()->put('id_nha_may', $account->id_nha_may);
                $request->session()->put('level', $account->level);
                switch ($account['level']) {
                    case 'Master':
                        return Redirect::to('Master');
                        break;
                    case 'Admin':
                        return Redirect::to('Admin');
                        break;
                    case 'office':
                        $vanPhong = vanPhong::where('id_account',$account->id_account)->select('id_van_phong')->first();
                        return Redirect::to('vanPhong/'.$vanPhong->id_van_phong.'/0');
                        break;
                    default:
                        return Redirect::to('User/'.$account->id_nha_may.'/0');
                        break;
                }
            }else{
                return response()->json(['error']);
            }
        }
    }
}
