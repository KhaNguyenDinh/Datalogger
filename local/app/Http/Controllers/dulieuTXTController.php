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
use App\nhaMay;
use App\khuVuc;
use App\alert;
use DateTime;

class dulieuTXTController extends Controller
{
	public function checkData($id_nha_may) {
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();
		$returm = 0;
		foreach ($khuVuc as $key => $value) {
			$newTxt = DB::table($value->folder_txt)
	            ->orderByDesc('time')->first();

	        if (!empty($newTxt)) {
	            $time =  $newTxt->time;
	            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));
				$interval = $date1->diff($date2);
				if ($interval->y== 0 && $interval->m == 0 && $interval->d == 0 && $interval->h == 0 && $interval->i<=1) {
					$returm = 1;
				}
			}
		}
	    return $returm;
	    // retoen = 1 ->[ có txt update ]=> load;
	}

	public function relay($id_nha_may){
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
		////////////////////////////
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();
		$list_total=['N'=>0,'C'=>0,'E'=>0,'bt'=>0,'alert'=>0,'error'=>0,'load'=>0,'connect'=>0,'total'=>count($khuVuc),'reload'=>0];
		$list_error=[];
		$name_status = ['N','C','E','bt','alert','error','load','connect'];

		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$newTxt = DB::table($value->folder_txt)
                ->orderByDesc('time')->first();
            $list_check = ['N'=>0,'C'=>0,'E'=>0,'bt'=>0,'alert'=>0,'error'=>0,'load'=>0,'connect'=>0];
            if (!empty($newTxt)) {
	            $time =  $newTxt->time;
	            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));
				$interval = $date1->diff($date2);
				$connect = "";
				if ($interval->y > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->m > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->d > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->h > 0) {$connect = "Mất tín hiệu";
				} elseif($interval->i > 30) {$connect = "Mất tín hiệu";}
				if ($connect!=='') {
					$list_check['load'] = $list_check['connect'] = 1;
				}
				/////////////////////////////////////////////////////
				if ($list_check['connect']==0) {
					$arrayData = json_decode($newTxt->data, true);
					$list_alert = [];
					if ($alert) {
						foreach ($alert as $key => $value_alert) {
							if ($value_alert['enable']=="YES") {
								$list_alert[$value_alert['name_alert']]=$value_alert;
							}
						}
					}
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
			$name_check = ['E','error','connect'];
			$error='';
			foreach ($name_check as $key => $name) {
				if ($list_check[$name]>0) {
					if ($name=='connect') {
						$error = $value->name_khu_vuc.' : Mất kết nối <br>';
					}elseif($name=='error'){
						$error = $value->name_khu_vuc.'Vượt ngưỡng <br>';
					}elseif($name=='E'){
						$error = $value->name_khu_vuc.'Lỗi thiết bị <br>';
					}
				}
			}
			$list_error[$value->name_khu_vuc]= $error;
		}
		foreach ($list_error as $key => $value) {
			echo $value;
		}
	}

}



