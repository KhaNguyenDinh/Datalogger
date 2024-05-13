<?php

namespace App\Http\Controllers;
use App\Services\CameraService;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\nhaMay;
use App\khuVuc;
use App\alert;
use App\camera;
use App\account;
use App\viTri;
use App\vanPhong;
use App\role;
use DateTime;


class viewController extends Controller
{
	public function connect($time){
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
	    $date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));
		$interval = $date1->diff($date2);
		$connect = "";
		if ($interval->y > 0) {$connect = "Mất tín hiệu";
		} elseif($interval->m > 0) {$connect = "Mất tín hiệu";
		} elseif($interval->d > 0) {$connect = "Mất tín hiệu";
		} elseif($interval->h > 0) {$connect = "Mất tín hiệu";
		} elseif($interval->i > 30) {$connect = "Mất tín hiệu";}
		return $connect;
	} //ok
	public function data_all(){
		$results = [];
		$name_status = ['connect','E','C','error','alert'];
		$status = ['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0,'total'=>0];
		$vanPhongs = vanPhong::select('id_van_phong')->get();
		$status['total'] = count($vanPhongs);
        $list_vanPhong =[];
        foreach ($vanPhongs as $key => $vanPhong) {
        	$data_vanPhong = $this->data_vanPhong($vanPhong->id_van_phong);
        	foreach ($name_status as $key => $name) {
				$status[$name] += $data_vanPhong['status_vanPhong'][$name];
			}
			array_push($list_vanPhong, $data_vanPhong);
        }
        $results = array_merge(['status'=>$status,'list_vanPhong'=>$list_vanPhong]);
        return $results;
	} // ok
	public function data_vanPhong($id_van_phong){
		$results = [];
		$name_status = ['connect','E','C','error','alert'];
		$status_vanPhong = ['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0,'total'=>0];
		$vanPhong = vanPhong::find($id_van_phong);
		$nhaMays = nhaMay::join('role', 'role.id_nha_may', '=', 'nhaMay.id_nha_may')
                    ->join('vanPhong', 'vanPhong.id_van_phong', '=', 'role.id_van_phong')
                    ->where('vanPhong.id_van_phong', $id_van_phong)
                    ->select('nhaMay.id_nha_may')
                    ->orderBy('nhaMay.id_nha_may')
                    ->get();
        $status_vanPhong['total'] = count($nhaMays);
        $list_nhaMay =[];
        foreach ($nhaMays as $key => $nhaMay) {
        	$data_nhaMay = $this->data_nhaMay($nhaMay->id_nha_may);
        	foreach ($name_status as $key => $name) {
				$status_vanPhong[$name] += $data_nhaMay['status_nhaMay'][$name];
			}
			array_push($list_nhaMay, $data_nhaMay);
        }
        $results = array_merge(['vanPhong'=>$vanPhong,'status_vanPhong'=>$status_vanPhong,'list_nhaMay'=>$list_nhaMay]);
        return $results;
	} // ok
	public function data_nhaMay($id_nha_may){
		$results = [];
		$name_status = ['connect','E','C','error','alert'];
		$nhaMay = nhaMay::find($id_nha_may);
		$status_nhaMay = ['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0,'total'=>0];

		$khuVucs = khuVuc::where('id_nha_may',$id_nha_may)->select('id_khu_vuc')->get();
		$status_nhaMay['total'] = count($khuVucs);
		$list_khuVuc = [];
		foreach ($khuVucs as $key => $khuVuc) {
			$data_khuVuc = $this->data_khuVuc($khuVuc->id_khu_vuc);
			foreach ($name_status as $key => $name) {
				$status_nhaMay[$name] += $data_khuVuc['status_khuVuc'][$name];
			}
			array_push($list_khuVuc, $data_khuVuc);
		}
		$results = array_merge(['nhaMay'=>$nhaMay,'status_nhaMay'=>$status_nhaMay,'list_khuVuc'=>$list_khuVuc]);
		return $results;
	} //ok
	public function data_khuVuc($id_khu_vuc){
		$results = [];
		$khuVuc = khuVuc::find($id_khu_vuc);
		$table_txt = $khuVuc->folder_txt;
		$status_khuVuc = ['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0];

		$alerts =alert::where('id_khu_vuc', $id_khu_vuc)->get();
		$list_alert = [];
		if ($alerts) {
			foreach ($alerts as $key => $alert) {
				if ($alert['enable']=="YES") {
					$list_alert[$alert['name_alert']]=$alert;
				}
			}
		}
		$newTxt = DB::table($table_txt)->orderByDesc('time')->first();

        
        if (!empty($newTxt)) {
            $time =  $newTxt->time;
            $connect = $this->connect($time);

			if ($connect=='') {
				$arrayData = json_decode($newTxt->data, true);

				foreach ($arrayData as $key1 => $value1) {
					if ($status_khuVuc['E'] == 0 ) {
						if ($status_khuVuc['C'] == 0 ) {
							switch ($value1['status']) {
								case 0: $status_khuVuc['N'] = 1;
									if (array_key_exists($value1['name'], $list_alert)) {
										$value2 = $list_alert[$value1['name']];
										if ($status_khuVuc['error']==0) {
											if ($status_khuVuc['alert']==0) {
												if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
													$status_khuVuc['error']=1;
												}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
													$status_khuVuc['alert']=1;
												}
											}
										}
									}							
									break;
								case 1:$status_khuVuc['C'] = 1; break;
								case 2:$status_khuVuc['E'] = 1; break;
							}
						}
					}
				}
			}else{
				$status_khuVuc['connect']=1;
			}
		}
		$results = array_merge(['khuVuc'=>$khuVuc,'status_khuVuc'=>$status_khuVuc,'list_alert'=>$list_alert,'newTxt'=>$newTxt]);
		return $results;
	} //ok


	////////view
	public function admin(){
		$results = [];
		$total = khuVuc::select('id_khu_vuc')->count();
		$name_status = ['connect','E','C','error','alert'];
		$status = ['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0,'total'=>$total];
		$vanPhongs = vanPhong::all();
		foreach ($vanPhongs as $key => $vanPhong) {
			$id_van_phong = $vanPhong->id_van_phong;
			$nhaMays = nhaMay::join('role', 'role.id_nha_may', '=', 'nhaMay.id_nha_may')
                    ->join('vanPhong', 'vanPhong.id_van_phong', '=', 'role.id_van_phong')
                    ->where('vanPhong.id_van_phong', $id_van_phong)
                    // ->select('nhaMay.id_nha_may')
                    ->orderBy('nhaMay.id_nha_may')
                    ->get();
            foreach ($nhaMays as $key => $nhaMay) {
            	$khuVucs = khuVuc::where('id_nha_may',$nhaMay->id_nha_may)->get();
            	foreach ($khuVucs as $key => $khuVuc) {
					$status_khuVuc = ['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0];
					$alerts =alert::where('id_khu_vuc', $khuVuc->id_khu_vuc)->get();
					$list_alert = [];
					if ($alerts) {
						foreach ($alerts as $key => $alert) {
							if ($alert['enable']=="YES") {
								$list_alert[$alert['name_alert']]=$alert;
							}
						}
					}
					$newTxt = DB::table($khuVuc->folder_txt)->orderByDesc('time')->first();
			        if (!empty($newTxt)) {
			            $time =  $newTxt->time;
			            $connect = $this->connect($time);

						if ($connect=='') {
							$arrayData = json_decode($newTxt->data, true);

							foreach ($arrayData as $key1 => $value1) {
								if ($status_khuVuc['E'] == 0 ) {
									if ($status_khuVuc['C'] == 0 ) {
										switch ($value1['status']) {
											case 0: $status_khuVuc['N'] = 1;
												if (array_key_exists($value1['name'], $list_alert)) {
													$value2 = $list_alert[$value1['name']];
													if ($status_khuVuc['error']==0) {
														if ($status_khuVuc['alert']==0) {
															if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
																$status_khuVuc['error']=1;
															}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
																$status_khuVuc['alert']=1;
															}
														}
													}
												}							
												break;
											case 1:$status_khuVuc['C'] = 1; break;
											case 2:$status_khuVuc['E'] = 1; break;
										}
									}
								}
							}
						}else{
							$status_khuVuc['connect']=1;
						}
					}
					foreach ($name_status as $key => $name) {
						$status[$name] += $status_khuVuc[$name];
					}
					array_push($results,['name_van_phong'=>$vanPhong->name_van_phong,'name_nha_may'=> $nhaMay->name_nha_may,'name_khu_vuc'=>$khuVuc->name_khu_vuc,'status_khuVuc'=>$status_khuVuc,'list_alert'=>$list_alert,'newTxt'=>$newTxt]);
            	}
            }
            
		}
		return view('User.admin', compact('results','status','name_status'));
	}
	///////////
	public function admin_home(){
		$name_status = ['connect','E','C','error','alert'];
		$results = [];
		$status=['connect'=>0,'E'=>0,'C'=>0,'error'=>0,'alert'=>0];
		$vanPhongs = vanPhong::all();
		$list_vanphong = [];
		foreach ($vanPhongs as $key => $vanPhong) {
			$data = $this->data_vanphong_home($vanPhong->id_van_phong);
			$status_vanPhong = $data['status'];
			foreach ($name_status as $key => $name) {
				$status[$name] += $status_vanPhong[$name];
			}
			array_push($list_vanphong, ['vanPhong'=>$vanPhong,'status_vanPhong'=>$status_vanPhong]);
		}
		$results = array_merge(['status'=>$status,'list_vanphong'=>$list_vanphong]);
		return view('User.admin', compact('results'));
	}
	public function vanphong_home($id_van_phong,$id_nha_may){
		$vanPhong = vanPhong::find($id_van_phong);
		$results = $this->data_vanphong_home($id_van_phong);
		return view('User.vanphong', compact('results','vanPhong','id_nha_may'));
	}

    // view
	public function showTrangChu($id_nha_may,$key_view){
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
		////////////////////////////
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();

		$results = [];
		$result_khuVuc=[];
		$list_total=['N'=>0,'C'=>0,'E'=>0,'bt'=>0,'alert'=>0,'error'=>0,'load'=>0,'connect'=>0,'total'=>count($khuVuc),'reload'=>0];
		$name_status = ['N','C','E','bt','alert','error','load','connect'];
		$show_txt=false;

		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$list_alert = [];
			if ($alert) {
				foreach ($alert as $key => $value_alert) {
					if ($value_alert['enable']=="YES") {
						$list_alert[$value_alert['name_alert']]=$value_alert;
					}
				}
			}
			$viTri = viTri::where('id_khu_vuc', $value->id_khu_vuc)->orderBy('vitri', 'asc')->get();
			$newTxt = DB::table($value->folder_txt)
                ->orderByDesc('time')->first();
            $txt = DB::table($value->folder_txt)
                ->orderByDesc('time')->limit(12)->get();
            $list_check = ['N'=>0,'C'=>0,'E'=>0,'bt'=>0,'alert'=>0,'error'=>0,'load'=>0,'connect'=>0];
            if (!empty($newTxt)) {
            	$show_txt=true;
	            $time =  $newTxt->time;
	            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));
				$interval = $date1->diff($date2);
				$connect = "";
				if ($interval->y > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->m > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->d > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->h > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->i > 10) {$connect = "Mất tín hiệu";}
				if ($connect!=='') {
					$list_check['load'] = $list_check['connect'] = 1;
				}
				/////////////////////////////////////////////////////
				if ($list_check['connect']==0) {
					$arrayData = json_decode($newTxt->data, true);

					foreach ($arrayData as $key1 => $value1) {
						if ($list_check['E'] == 0 ) {
							if ($list_check['C'] == 0 ) {
								switch ($value1['status']) {
									case 0: $list_check['N'] = 1;
										if (array_key_exists($value1['name'], $list_alert)) {
											$value2 = $list_alert[$value1['name']];
											if ($list_check['error']==0) {
												if ($list_check['alert']==0) {
													if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
														$list_check['error']=1;
													}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
														$list_check['alert']=1;
													}
												}
											}
										}							
										break;
									case 1:$list_check['C'] = 1; break;
									case 2:$list_check['E'] = 1; break;
								}
							}
						}
					}
				}
			}	
			array_push($result_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'viTri'=>$viTri,'newTxt'=>$newTxt,'txt'=>$txt,'list_check'=>$list_check]);
			foreach ($name_status as $key => $value) {
				$list_total[$value] += $list_check[$value];
			}
		}
		if ($list_total['load']>0 && $list_total['load'] < $list_total['total']) {
			$list_total['reload']=1;
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'result_khuVuc'=>$result_khuVuc,'list_total'=>$list_total]);
		if ($show_txt) {
			return view('User.home', compact('results','key_view'));
		}else{
			echo "không có txt truyền về";
		}
	}
	public function dataKhuVuc($id_khu_vuc, $startTime, $endTime){
		$khuVucGetId = khuVuc::find($id_khu_vuc);
		$nhaMayGetId = nhaMay::find($khuVucGetId['id_nha_may']);
		$khuVuc = khuVuc::where('id_nha_may',$khuVucGetId['id_nha_may'])->get();
		$alert = alert::where('id_khu_vuc',$id_khu_vuc)->get();
		$camera = camera::where('id_khu_vuc',$id_khu_vuc)->get();
		$results = []; $result_khuVuc = [];

		if ($startTime=="NO" || $endTime=="NO") {
			$txt = DB::table($khuVucGetId['folder_txt'])
                ->orderBy('time')
                ->limit(12)
                ->get();
		}else{
			$txt = DB::table($khuVucGetId['folder_txt'])
                ->orderBy('time')
                ->whereBetween('time', [$startTime, $endTime])
                ->get();
        }
        array_push($result_khuVuc, ['khuVucGetId'=>$khuVucGetId,'alert'=>$alert,'txt'=>$txt]);
        $results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'camera'=>$camera,'result_khuVuc'=>$result_khuVuc]);

	    return $results;
	}
	public function showKhuVuc(Request $request,$id_khu_vuc,$action){
		if ($action=='updatealert') {
			$data = alert::where('id_khu_vuc',$id_khu_vuc)->get();
			return view('User.alert', compact('data','action','id_khu_vuc'));
		}
		$show_Alert='';
		$results = $this->dataKhuVuc($id_khu_vuc,'NO','NO');
		if ($action=='Alert') {
			$result_txt = [];
			$results['result_khuVuc'][0]['txt']=new Collection($result_txt);
		}
		return view('User.khuVuc', compact('results','action','show_Alert'));
	}
	public function postShowKhuVuc(Request $request, $id_khu_vuc,$action){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'startTime' => 'required',
		        'endTime' => 'required|after:startTime',
		    ],
		    [
		        'endTime.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.',
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
        	$startTime = $request->startTime;
        	$endTime = $request->endTime;
        	$results = $this->dataKhuVuc($id_khu_vuc,$startTime,$endTime);
        	

        	if ($action=='Alert') {
        		$alert = $results['result_khuVuc'][0]['alert'];
        		$list_alert = [];
				if ($alert) {
					foreach ($alert as $key => $value) {
						if ($value['enable']=="YES") {
							$list_alert[$value['name_alert']]=$value;
						}
					}
				}
        		$txt = $results['result_khuVuc'][0]['txt'];
        		if ($alert==null) {
        			$results['result_khuVuc'][0]['txt']=null;
        		}else{
        			$result_txt=[];
					foreach ($txt as $key => $value) {
						$arrayData = json_decode($value->data, true);
						$result_alert=false; $result_error=false;

						foreach ($arrayData as $key1 => $value1) {
							if (array_key_exists($value1['name'], $list_alert)) {
								$value2 = $list_alert[$value1['name']];

								if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
									$result_error=true;
								}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
									$result_alert=true;
								}

							}							
						}
						
						if ($request->Alert=='Alert' && ( $result_error==true || $result_alert==true ) ) {
							array_push($result_txt,$value);
						}elseif ($request->Alert=='Error' && $result_error==true) {
							array_push($result_txt,$txt[$key]);
						}
					}	
        		}
        		$result_txt = new Collection($result_txt);
        		$results['result_khuVuc'][0]['txt'] = $result_txt;
        	}

        	// dd($results);
        	if (isset($request->action) && $request->action=='execel') {
				$data=[];$ykeys=[];$name=['Time'];
				$txt = $results['result_khuVuc'][0]['txt'];
				$th = json_decode($txt[0]->data, true);
				foreach ($th as $key => $value) {
					$name=array_merge($name,array($value['name']));
				}
				array_push($data, $name);
				foreach ($txt as $key => $value) {
					$time = $value->time;
					$arrayData = json_decode($value->data, true);
					foreach ($arrayData as $key => $value) {
					  $ykeys = array_merge($ykeys,array('year' => $time, $value['name']=>number_format($value['number'],2)) );
					}
					array_push($data, $ykeys);
				}
				return Excel::download(new UsersExport($data), 'data.xlsx');
        	}else{
        		// dd($results);
        		$show_Alert='';
        		if ($action=='Alert') {
        			$show_Alert=$request->Alert;
        		}
        		return view('User.khuVuc', compact('results','startTime','endTime','action','show_Alert'));
        	}
        }
    }

    //////////////////////////////////////////////
    // alert
    public function alert_delete($id){
    	$data = alert::find($id)->delete();
        return Redirect()->back()->withInput();
    }
    public function alert_postinsert(Request $request, $id_khu_vuc){
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
		    	return Redirect()->back()->withInput();
	    	}else{
	    		return response()->json(['success'=>$request->name.' dang ton tai']);
	    	}
        }
    }
    public function alert_postupdate(Request $request, $id_khu_vuc){
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
	    	for ($i=0; $i < count($request->id_alert) ; $i++) { 
				$count = alert::where('name_alert',$request->name_alert[$i])->where('id_khu_vuc',$id_khu_vuc)->where('id_alert','!=',$request->id_alert[$i])->count();
				$count=0;
		    	if ($count==0) {
			    	$update = alert::find($request->id_alert[$i]);
			    	$update->name_alert = $request->name_alert[$i];
			    	$update->minmin = $request->minmin[$i];
			    	$update->min = $request->min[$i];
			    	$update->max = $request->max[$i];
			    	$update->maxmax = $request->maxmax[$i];
			    	$update->enable = $request->enable[$i];
			    	$update->save();
		    	}else{
		    		return response()->json(['success'=>$request->name.' dang ton tai']);
		    	}
	    	}
	    	return Redirect()->back()->withInput();
	        }
    }
    // user
    public function user_update(Request $request){
        $data = account::where('name_account',session('name_account'))
              ->where('pass_account',session('pass_account'))
              ->where('id_nha_may',session('id_nha_may'))
              ->first();
        $id_account = $data->id_account;$name_account = $data->name_account;
        return view('login.userUpdate')->with(compact('id_account','name_account'));
    }
    public function user_postUpdate(Request $request, $id_account){
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
}
