<?php
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Collection;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\nhaMay;
use App\khuVuc;
use App\alert;
use App\camera;
use App\account;
use App\viTri;
use DateTime;
use Illuminate\Pagination\LengthAwarePaginator;


class dulieuTXTController extends Controller
{
	public function relay($id_nha_may){
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
		////////////////////////////
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();
		$total_alert=0; $total_error=0;$total_error_connect=0;

		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$newTxt = DB::table($value->folder_txt)->orderByDesc('time')->first();

            if (!empty($newTxt)) {
				$arrayData = json_decode($newTxt->data, true);
				$TrangThai=$status = "norm";
				$list_alert = [];
				if ($alert) {
					foreach ($alert as $key => $value_alert) {
						if ($value_alert['enable']=="YES") {
							$list_alert[$value_alert['name_alert']]=$value_alert;
						}
					}
				}
				$check_error="NO"; $check_alert = "NO";
					if ($check_error=="NO") {
					foreach ($arrayData as $key1 => $value1) {
						if (array_key_exists($value1['name'], $list_alert)) {
							$value2 = $list_alert[$value1['name']];

							if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
								$TrangThai="error";
								if ($check_error=="NO") {
									$total_error=$total_error+1;
								}
								$check_error="YES";
							}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
								$TrangThai="alert";
								if ($check_alert=="NO") {
									$total_alert=$total_alert+1;
								}
								$check_alert="YES";
							}
						}
					}
				}

				switch ($value1['status']) {
					// case 0:$status = 'norm';break;
					case 1:$status = 'alert';break;
					case 2:$status = 'error';break;
				}
			}	
		}
		if ($total_alert>0) { $error = 'Chuẩn bị vượt ngưỡng';}
		if ($total_error>0) { $error = 'Vượt ngưỡng';}
		echo $error;
	}

    public function resetTxt(){
    	$khuVucAll = khuVuc::all();
    	foreach ($khuVucAll as $key => $khuVuc) {
    		$count = DB::table($khuVuc->folder_txt)->count();
    		if ($count>25920) {
    			DB::table($khuVuc->folder_txt)
			    ->orderByDesc('time')
			    ->skip(25920) // Bỏ qua 25920 bản ghi đầu tiên (3 tháng)
			    ->pluck('time')
			    ->each(function ($time) use ($khuVuc) {
			        DB::table($khuVuc->folder_txt)
			            ->where('time', $time)
			            ->delete();
			    });
    		}
    	}
    	return Redirect()->back()->withInput();
    }
	public function showTrangChu($id_nha_may,$key_view){
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
		////////////////////////////
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();

		$results = [];
		$result_khuVuc=[];
		$total_alert=0; $total_error=0;$total = count($khuVuc);$total_error_connect=0;

		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$viTri = viTri::where('id_khu_vuc', $value->id_khu_vuc)->orderBy('vitri', 'asc')->get();
			$newTxt = DB::table($value->folder_txt)
                ->orderByDesc('time')->first();
            $txt = DB::table($value->folder_txt)
                ->orderByDesc('time')->limit(12)->get();
            if (count($txt)>0) {
	            $time =  $newTxt->time;
	            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));
				$interval = $date1->diff($date2);
				$connect = "";
				if ($interval->y > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->m > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->d > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->h > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->i > 150) {$connect = "Mất tín hiệu";}
				if ($connect!=='') {
					$total_error_connect = $total_error_connect+1;
				}
				/////////////////////////////////////////////////////
				$arrayData = json_decode($newTxt->data, true);
				$TrangThai=$status = "norm";
				$list_alert = [];
				if ($alert) {
					foreach ($alert as $key => $value_alert) {
						if ($value_alert['enable']=="YES") {
							$list_alert[$value_alert['name_alert']]=$value_alert;
						}
					}
				}
				$check_error="NO"; $check_alert = "NO";
					if ($check_error=="NO") {
					foreach ($arrayData as $key1 => $value1) {
						if (array_key_exists($value1['name'], $list_alert)) {
							$value2 = $list_alert[$value1['name']];

							if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
								$TrangThai="error";
								if ($check_error=="NO") {
									$total_error=$total_error+1;
								}
								$check_error="YES";
							}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
								$TrangThai="alert";
								if ($check_alert=="NO") {
									$total_alert=$total_alert+1;
								}
								$check_alert="YES";
							}
						}
					}
				}

				switch ($value1['status']) {
					// case 0:$status = 'norm';break;
					case 1:$status = 'alert';break;
					case 2:$status = 'error';break;
				}
				array_push($result_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'viTri'=>$viTri,'newTxt'=>$newTxt,'txt'=>$txt,'TrangThai'=>$TrangThai,'status'=>$status,'connect'=>$connect]);
			}	
		}

		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'total'=>$total,'total_error'=>$total_error,'total_alert'=>$total_alert,'total_error_connect'=>$total_error_connect,'result_khuVuc'=>$result_khuVuc]);
			////////////////////////////////
		return view('User.trangChu', compact('results','key_view'));
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
                ->orderByDesc('time')
                ->limit(12)
                ->get();
		}else{
			$txt = DB::table($khuVucGetId['folder_txt'])
                ->orderByDesc('time')
                ->whereBetween('time', [$startTime, $endTime])
                ->get();
        }
        array_push($result_khuVuc, ['khuVucGetId'=>$khuVucGetId,'alert'=>$alert,'txt'=>$txt]);
        $results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'camera'=>$camera,'result_khuVuc'=>$result_khuVuc]);

	    return $results;
	}
	public function showKhuVuc(Request $request,$id_khu_vuc,$action){
		$show_Alert='';
		$results = $this->dataKhuVuc($id_khu_vuc,'NO','NO');
		if ($action=='Alert') {
			$result_txt = [];
			$results['result_khuVuc'][0]['txt']=new Collection($result_txt);
		}
		return view('User.khuVuc', compact('results','action','show_Alert',));
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
}
