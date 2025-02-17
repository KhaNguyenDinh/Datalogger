<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\nhaMay;
use App\khuVuc;
use App\alert;
use App\email;
use DateTime;
use Mail;

class LogService
{
	public function check_sent_mail($id_nha_may){
		$currentDateTime = new DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
		$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
		$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
		////////////////////////////
		$nhaMayGetId = nhaMay::find($id_nha_may);
		$khuVuc = khuVuc::where('id_nha_may', $id_nha_may)->orderBy('id_khu_vuc')->get();
		$comment = '';
		$value=[];

		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khu_vuc', $value->id_khu_vuc)->get();
			$newTxt = DB::table($value->folder_txt)
                ->orderByDesc('time')->first();
            $list_check = ['N'=>0,'C'=>0,'E'=>0,'bt'=>0,'alert'=>0,'error'=>0,'load'=>0,'connect'=>0];
            $list_error =[];
            if (!empty($newTxt)) {
	            $time =  $newTxt->time;
	            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));
				$interval = $date1->diff($date2);
				$connect = false;
				if ($interval->y > 0) {$connect = true;
				} elseif($interval->m > 0) {$connect = true;
				} elseif($interval->d > 0) {$connect = true;
				} elseif($interval->h > 0) {$connect = true;
				} elseif($interval->i > 30) {$connect = true;}
				if ($connect) {
					$list_check['load'] = $list_check['connect'] = 1;
					$comment = $comment.'MẤT TÍN HIỆU';
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
														$comment = $comment.' Vượt ngưỡng :'.$value1['name'].'_'.$value1['number'].'_'.$value1['unit'];
													}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
														$list_check['alert']=1;
													}
												}
											}
										}							
										break;
									case 1:$list_check['C'] = 1; break;
									case 2:$list_check['E'] = 1;
										$comment = $comment.'Lỗi thiết bị _'.$value1['name'].'_'.$value1['number'].'_'.$value1['unit'];
										 break;
								}
							}
						}
					}

				}
			}	
			$value_khuvuc = ['time'=>$time,'TQT'=>$value->name_khu_vuc,'comment'=>$comment];
			$value = array_merge($value_khuvuc);
		}

		return $value;
	}
	public function sent_mail($time,$TQT,$comment,$mail_sent){
        Mail::send('mail',compact('time','TQT','comment','mail_sent'), function($email) use($comment,$mail_sent){
            $email->subject('Canh Bao');
            $email->to($mail_sent);
        });
    }
    public function email(){
    	$data = email::select('id_nha_may')->distinct()->pluck('id_nha_may')->all();
    	foreach ($data as $key => $value) {
    		$error = $this->check_sent_mail($value);
    		if ($error['comment']!='') {
    			$datas = email::where('id_nha_may',$value)->select('email')->distinct()->pluck('email')->all();
    			foreach ($datas as $key => $email) {
    				$this->sent_mail($error['time'],$error['TQT'],$error['comment'],$email);
    			}
    		}
    	}
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
    } //ok
	public function loadTxtAll(){
    	$khuVucAll = khuVuc::all();
    	foreach ($khuVucAll as $key => $khuVuc) {
			$type = $khuVuc->type;
			$id_khu_vuc = $khuVuc->id_khu_vuc;
			$folder_txt = $khuVuc->folder_txt;
			if ($type=='ymd') {
				$directoryPath = 'public/TXT/'.$folder_txt;
				$subDirectories = Storage::directories($directoryPath);

				if (!empty($subDirectories)) { // check thu muc

				    foreach ($subDirectories as $subDirectory) {
				    	$folderName = basename($subDirectory);
				    	if (strlen($folderName)!=4) {
							$files = Storage::files($subDirectory);
							foreach ($files as $file) {

							    $fileContents = Storage::disk('local')->get($file);
							    $lines = explode("\n", $fileContents);
							    // Xử lý từng dòng
							    $datas=[];$data=[];$time=false;
							    
							    foreach ($lines as $line) {
							    	$elements = explode("\t", $line);
							    	if (isset($elements[4])) {
										$txt = [
											'id_khu_vuc' => $id_khu_vuc,
											'name' => $elements[0],
											'number' => $elements[1],
											'unit' => $elements[2],
											'time' => date("Y-m-d H:i:s", strtotime($elements[3])),
											'status' => $elements[4],
										];
										if ($time==false) {
											$time = date("Y-m-d H:i:s",strtotime($elements[3]));
										}
										if ($time==date("Y-m-d H:i:s",strtotime($elements[3]))) {
											array_push($data, $txt);
										}else{
											array_push($datas, $data);
											$data = [];
											array_push($data, $txt);
											$time = date("Y-m-d H:i:s",strtotime($elements[3]));

										}										    		
							    	}

							    }
							    array_push($datas, $data);
								foreach ($datas as $key => $array) {
								    if (!empty($array) && is_array($array) && isset($array[0])) {
								        $dataToInsert = [
								            'id_khu_vuc' => $array[0]["id_khu_vuc"],
								            'time' => $array[0]['time'],
								            'data' => json_encode($array)
								        ];
								        DB::table($folder_txt)->insert($dataToInsert);
								    }
								}
									// Tách đoạn đường dẫn dựa trên dấu /
									$parts = explode('/', $file);
									// Lấy tên file
									$fileName = end($parts);
									// Loại bỏ $directoryPath khỏi đường dẫn để lấy thư mục và tên file mới
									$relativePath = str_replace($directoryPath . '/', '', $file);


									$sourcePath = storage_path('app/public/TXT/'.$folder_txt.'/'.$relativePath);

									$destinationPath = storage_path('app/public/TXT_mov/'.$folder_txt.'/'.$relativePath);

									// Tạo thư mục B nếu nó chưa tồn tại
									if (!File::isDirectory(dirname($destinationPath))) {
									    File::makeDirectory(dirname($destinationPath), 0755, true, true);
									}

									// Di chuyển file từ thư mục A sang thư mục B
									File::move($sourcePath, $destinationPath);

									// Xóa file ở thư mục A nếu di chuyển thành công
									if (File::exists($destinationPath)) {
									    File::delete($sourcePath);
									}
							}

							$files = Storage::files($subDirectory);
							if (empty($files)) {
							    Storage::deleteDirectory($subDirectory);
							    // echo "Đã xóa thư mục $subDirectory vì không còn file trong đó.";
							}
						}

				    }
				}
			}
			if ($type='y/m/d') {
				$directoryPath = 'public/TXT/'.$folder_txt;
				$subDirectories = Storage::directories($directoryPath);

				if (!empty($subDirectories)) { // check thu muc nam
					foreach ($subDirectories as $subDirectory) {
						$folderName = basename($subDirectory);
				    	if (strlen($folderName)==4) {
							$subDirectories1 = Storage::directories($subDirectory);

							if (!empty($subDirectories1)) {
								foreach ($subDirectories1 as  $subDirectory1) {
									$subDirectories2 = Storage::directories($subDirectory1);
									foreach ($subDirectories2 as $subDirectory2) {

										$files = Storage::files($subDirectory2);
										foreach ($files as $file) {

										    $fileContents = Storage::disk('local')->get($file);
										    $lines = explode("\n", $fileContents);
										    // Xử lý từng dòng
										    $datas=[];$data=[];$time=false;
										    
										    foreach ($lines as $line) {
										    	$elements = explode("\t", $line);
										    	if (isset($elements[4])) {
													$txt = [
														'id_khu_vuc' => $id_khu_vuc,
														'name' => $elements[0],
														'number' => $elements[1],
														'unit' => $elements[2],
														'time' => date("Y-m-d H:i:s", strtotime($elements[3])),
														'status' => $elements[4],
													];
													if ($time==false) {
														$time = date("Y-m-d H:i:s",strtotime($elements[3]));
													}
													if ($time==date("Y-m-d H:i:s",strtotime($elements[3]))) {
														array_push($data, $txt);
													}else{
														array_push($datas, $data);
														$data = [];
														array_push($data, $txt);
														$time = date("Y-m-d H:i:s",strtotime($elements[3]));

													}										    		
										    	}

										    }
										    array_push($datas, $data);
											foreach ($datas as $key => $array) {
											    if (!empty($array) && is_array($array) && isset($array[0])) {
											        $dataToInsert = [
											            'id_khu_vuc' => $array[0]["id_khu_vuc"],
											            'time' => $array[0]['time'],
											            'data' => json_encode($array)
											        ];
											        DB::table($folder_txt)->insert($dataToInsert);
											    }
											}

												// Tách đoạn đường dẫn dựa trên dấu /
												$parts = explode('/', $file);
												// Lấy tên file
												$fileName = end($parts);
												// Loại bỏ $directoryPath khỏi đường dẫn để lấy thư mục và tên file mới
												$relativePath = str_replace($directoryPath . '/', '', $file);


												$sourcePath = storage_path('app/public/TXT/'.$folder_txt.'/'.$relativePath);

												$destinationPath = storage_path('app/public/TXT_mov/'.$folder_txt.'/'.$relativePath);

												// Tạo thư mục B nếu nó chưa tồn tại
												if (!File::isDirectory(dirname($destinationPath))) {
												    File::makeDirectory(dirname($destinationPath), 0755, true, true);
												}

												// Di chuyển file từ thư mục A sang thư mục B
												File::move($sourcePath, $destinationPath);

												// Xóa file ở thư mục A nếu di chuyển thành công
												if (File::exists($destinationPath)) {
												    File::delete($sourcePath);
												}

										}
										$files = Storage::files($subDirectory2);
										if (empty($files)) {
										    Storage::deleteDirectory($subDirectory2);
										    //echo "Đã xóa thư mục $subDirectory2 vì không còn file trong đó.";
										}
									}
									$directories = Storage::directories($subDirectory1);
									if (empty($directories)) {
									    Storage::deleteDirectory($subDirectory1);
									    //echo "Đã xóa thư mục $subDirectory1 vì không còn thư mục con trong đó.";
									}
								}
							}
							$directories = Storage::directories($subDirectory);
							if (empty($directories)) {
							    Storage::deleteDirectory($subDirectory);
							    //echo "Đã xóa thư mục $subDirectory1 vì không còn thư mục con trong đó.";
							}
				    	}
					}
				}
			}
    	}
    	return Redirect()->back()->withInput();
    } // ok

}
