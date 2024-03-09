<?php
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\nhaMay;
use App\khuVuc;
use App\alert;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class dulieuTXTController extends Controller
{
	//////// select
	public function nhaMay(){
		$results = nhaMay::all();
		return $results;}
	public function nhaMayGetId($id_nhaMay){
		$results = nhaMay::find($id_nhaMay);
		return $results;}
	public function khuVucAll(){
		$results = khuVuc::all();
		return $results;}	
	public function khuVuc($id_nhaMay){
		$results = khuVuc::where('id_nhaMay',$id_nhaMay)->get();
		return $results;}
	public function khuVucGetId($id_khuVuc){
		$results = khuVuc::find($id_khuVuc);
		return $results;}
	public function alert($id_khuVuc){
		$results = alert::find($id_khuVuc);
		return $results;}
///////////// Load TXT
	//  insert & move TXT
	public function loadTxtAll(){
    	$khuVucAll = $this->khuVucAll();
    	foreach ($khuVucAll as $key => $khuVuc) {
			$type = $khuVuc->type;
			$id_khuVuc = $khuVuc->id_khuVuc;
			$folder_TXT = $khuVuc->folder_TXT;

			if ($type=='ymd') {
				$directoryPath = 'public/TXT/'.$folder_TXT;
				$subDirectories = Storage::directories($directoryPath);

				if (!empty($subDirectories)) { // check thu muc

				    foreach ($subDirectories as $subDirectory) {
				    	$folderName = basename($subDirectory);
				    	if (strlen($folderName)!=4) {
							$files = Storage::files($subDirectory);
							foreach ($files as $file) {
								$time_file = substr($file,strlen($file)-18,14);
								$time_file =date("Y-m-d H:i",strtotime($time_file));
							    $fileContents = Storage::disk('local')->get($file);
							 	    // Tách nội dung thành các dòng
							    $lines = explode("\n", $fileContents);
							    // Xử lý từng dòng
							    $mov=''; $delete = '';$time_txt = '';
							    $array = [];
							    foreach ($lines as $line) {
							    	$elements = explode("\t", $line);
							    	if (isset($elements[4])) {
							    		$array[] = [
											'id_khuVuc' => $id_khuVuc,
											'name' => $elements[0],
											'number' => $elements[1],
											'unit' => $elements[2],
											'time' => date("Y-m-d H:i:s", strtotime($elements[3])),
											'status' => $elements[4],
										];
										if ($time_txt=='') {
											$time_txt = date("Y-m-d H:i:s", strtotime($elements[3]) );
										}

							    		if ($mov=='') {
							    			if (date("Y-m-d H:i",strtotime($elements[3])) !== $time_file) {
									    		$mov = "NO";
									    	}else{
									    		$mov = "YES";
									    	}
							    		}
							    		if ($delete=='') {
							    			$existingRecord = DB::table($folder_TXT)->where('id_khuVuc', $id_khuVuc)
											    ->where('time', date("Y-m-d H:i:s",strtotime($elements[3])))
											    ->first();
											if ($existingRecord) {	$delete = "YES";
											}else{ $delete="NO";}
							    		}
							    	}
							    }
							    if ($mov =='YES') {
								    if ($delete=="YES") {
								    	DB::table($folder_TXT)->where('time', $existingRecord->time)->delete();
								    }
								    $dataToInsert= [
											'id_khuVuc' => $id_khuVuc,
											'time'=>$time_txt,
											'data'=>json_encode($array)
										];
								    DB::table($folder_TXT)->insert($dataToInsert);
									// Tách đoạn đường dẫn dựa trên dấu /
									$parts = explode('/', $file);
									// Lấy tên file
									$fileName = end($parts);
									// Loại bỏ $directoryPath khỏi đường dẫn để lấy thư mục và tên file mới
									$relativePath = str_replace($directoryPath . '/', '', $file);


									$sourcePath = storage_path('app/public/TXT/'.$folder_TXT.'/'.$relativePath);

									$destinationPath = storage_path('app/public/TXT_mov/'.$folder_TXT.'/'.$relativePath);

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
			// if ($type='y/m/d') {
			// 	$directoryPath = 'public/TXT/'.$folder_TXT;
			// 	$subDirectories = Storage::directories($directoryPath);

			// 	if (!empty($subDirectories)) { // check thu muc nam
			// 		foreach ($subDirectories as $subDirectory) {
			// 			$folderName = basename($subDirectory);
			// 	    	if (strlen($folderName)==4) {
			// 				$subDirectories1 = Storage::directories($subDirectory);

			// 				if (!empty($subDirectories1)) {
			// 					foreach ($subDirectories1 as  $subDirectory1) {
			// 						$subDirectories2 = Storage::directories($subDirectory1);
			// 						foreach ($subDirectories2 as $subDirectory2) {

			// 							$files = Storage::files($subDirectory2);
			// 							foreach ($files as $file) {
			// 								$time_file = substr($file,strlen($file)-18,14);
			// 								$time_file =date("Y-m-d H:i",strtotime($time_file));
			// 							    $fileContents = Storage::disk('local')->get($file);
			// 							 	    // Tách nội dung thành các dòng
			// 							    $lines = explode("\n", $fileContents);
			// 							    // Xử lý từng dòng
			// 							    $mov='YES'; $delete = "NO";
			// 							    $dataToInsert = [];
			// 							    foreach ($lines as $line) {
			// 							    	$elements = explode("\t", $line);
			// 							    	if (isset($elements[4])) {
			// 							    		$dataToInsert[] = [
			// 											'id_khuVuc' => $id_khuVuc,
			// 											'name' => $elements[0],
			// 											'number' => $elements[1],
			// 											'unit' => $elements[2],
			// 											'time' => date("Y-m-d H:i:s", strtotime($elements[3])),
			// 											'status' => $elements[4],
			// 										];
			// 							    		if ($mov=='') {
			// 							    			if (date("Y-m-d H:i",strtotime($elements[3])) !== $time_file) {
			// 									    		$mov = "NO"; break;
			// 									    	}else{
			// 									    		$mov = "YES"; break;
			// 									    	}
			// 							    		}
			// 							    		if ($delete=='') {
			// 							    			$existingRecord = DB::table($folder_TXT)->where('id_khuVuc', $id_khuVuc)
			// 											    ->where('name', $elements[0])
			// 											    ->where('time', date("Y-m-d H:i:s",strtotime($elements[3])))
			// 											    ->first();
			// 											if ($existingRecord) {	$delete = "YES";break;
			// 											}else{ $delete="NO";break;}
			// 							    		}
			// 							    	}
			// 							    }
			// 							    if ($mov =='YES') {
			// 								    if ($delete=="YES") {
			// 								    	DB::table($folder_TXT)->where('time', $existingRecord->time)->delete();
			// 								    }
			// 								    DB::table($folder_TXT)->insert($dataToInsert);										    
			// 									// Tách đoạn đường dẫn dựa trên dấu /
			// 									$parts = explode('/', $file);
			// 									// Lấy tên file
			// 									$fileName = end($parts);
			// 									// Loại bỏ $directoryPath khỏi đường dẫn để lấy thư mục và tên file mới
			// 									$relativePath = str_replace($directoryPath . '/', '', $file);


			// 									$sourcePath = storage_path('app/public/TXT/'.$folder_TXT.'/'.$relativePath);

			// 									$destinationPath = storage_path('app/public/TXT_mov/'.$folder_TXT.'/'.$relativePath);

			// 									// Tạo thư mục B nếu nó chưa tồn tại
			// 									if (!File::isDirectory(dirname($destinationPath))) {
			// 									    File::makeDirectory(dirname($destinationPath), 0755, true, true);
			// 									}

			// 									// Di chuyển file từ thư mục A sang thư mục B
			// 									File::move($sourcePath, $destinationPath);

			// 									// Xóa file ở thư mục A nếu di chuyển thành công
			// 									if (File::exists($destinationPath)) {
			// 									    File::delete($sourcePath);
			// 									}
			// 								}

			// 							}
			// 							$files = Storage::files($subDirectory2);
			// 							if (empty($files)) {
			// 							    Storage::deleteDirectory($subDirectory2);
			// 							    // echo "Đã xóa thư mục $subDirectory2 vì không còn file trong đó.";
			// 							}
			// 						}
			// 						$directories = Storage::directories($subDirectory1);
			// 						if (empty($directories)) {
			// 						    Storage::deleteDirectory($subDirectory1);
			// 						    // echo "Đã xóa thư mục $subDirectory1 vì không còn thư mục con trong đó.";
			// 						}
			// 					}
			// 				}
			// 				$directories = Storage::directories($subDirectory);
			// 				if (empty($directories)) {
			// 				    Storage::deleteDirectory($subDirectory);
			// 				    // echo "Đã xóa thư mục $subDirectory1 vì không còn thư mục con trong đó.";
			// 				}
			// 	    	}
			// 		}
			// 	}
			// }
    	}
    	// return Redirect()->back()->withInput();
    }

    public function loadTxtNhaMay($id_nhaMay){
    	$khuVucAll = $this->khuVuc($id_nhaMay);
    	foreach ($khuVucAll as $key => $khuVuc) {
			$folder_TXT = $khuVuc->folder_TXT;
			$type = $khuVuc->type;
			$id_khuVuc = $khuVuc->id_khuVuc;

			if ($type=='ymd') {
				$directoryPath = 'public/TXT/'.$folder_TXT;
				$subDirectories = Storage::directories($directoryPath);

				if (!empty($subDirectories)) { // check thu muc

				    foreach ($subDirectories as $subDirectory) {
				    	$folderName = basename($subDirectory);
				    	if (strlen($folderName)!=4) {
							$files = Storage::files($subDirectory);
							foreach ($files as $file) {
								$time_file = substr($file,strlen($file)-18,14);
								$time_file =date("Y-m-d H:i",strtotime($time_file));
							    $fileContents = Storage::disk('local')->get($file);
							 	    // Tách nội dung thành các dòng
							    $lines = explode("\n", $fileContents);
							    // Xử lý từng dòng
							    $mov='YES'; $delete = "NO";
							    $dataToInsert = [];
																				
							    foreach ($lines as $line) {
							    	$elements = explode("\t", $line);
							    	if (isset($elements[4])) {
							    		$dataToInsert[] = [
											'id_khuVuc' => $id_khuVuc,
											'name' => $elements[0],
											'number' => $elements[1],
											'unit' => $elements[2],
											'time' => date("Y-m-d H:i:s", strtotime($elements[3])),
											'status' => $elements[4],
										];
							    		if ($mov=='') {
							    			if (date("Y-m-d H:i",strtotime($elements[3])) !== $time_file) {
									    		$mov = "NO"; break;
									    	}else{
									    		$mov = "YES"; break;
									    	}
							    		}
							    		if ($delete=='') {
							    			$existingRecord = DB::table($folder_TXT)->where('id_khuVuc', $id_khuVuc)
											    ->where('name', $elements[0])
											    ->where('time', date("Y-m-d H:i:s",strtotime($elements[3])))
											    ->first();
											if ($existingRecord) {	$delete = "YES";break;
											}else{ $delete="NO";break;}
							    		}
							    	}
							    }
							    if ($mov =='YES') {
								    if ($delete=="YES") {
								    	DB::table($folder_TXT)->where('time', $existingRecord->time)->delete();
								    }
								    DB::table($folder_TXT)->insert($dataToInsert);
									// Tách đoạn đường dẫn dựa trên dấu /
									$parts = explode('/', $file);
									// Lấy tên file
									$fileName = end($parts);
									// Loại bỏ $directoryPath khỏi đường dẫn để lấy thư mục và tên file mới
									$relativePath = str_replace($directoryPath . '/', '', $file);


									$sourcePath = storage_path('app/public/TXT/'.$folder_TXT.'/'.$relativePath);

									$destinationPath = storage_path('app/public/TXT_mov/'.$folder_TXT.'/'.$relativePath);

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
				$directoryPath = 'public/TXT/'.$folder_TXT;
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
											$time_file = substr($file,strlen($file)-18,14);
											$time_file =date("Y-m-d H:i",strtotime($time_file));
										    $fileContents = Storage::disk('local')->get($file);
										 	    // Tách nội dung thành các dòng
										    $lines = explode("\n", $fileContents);
										    // Xử lý từng dòng
										    $mov='YES'; $delete = "NO";
										    $dataToInsert = [];
										    foreach ($lines as $line) {
										    	$elements = explode("\t", $line);
										    	if (isset($elements[4])) {
										    		$dataToInsert[] = [
														'id_khuVuc' => $id_khuVuc,
														'name' => $elements[0],
														'number' => $elements[1],
														'unit' => $elements[2],
														'time' => date("Y-m-d H:i:s", strtotime($elements[3])),
														'status' => $elements[4],
													];
										    		if ($mov=='') {
										    			if (date("Y-m-d H:i",strtotime($elements[3])) !== $time_file) {
												    		$mov = "NO"; break;
												    	}else{
												    		$mov = "YES"; break;
												    	}
										    		}
										    		if ($delete=='') {
										    			$existingRecord = DB::table($folder_TXT)->where('id_khuVuc', $id_khuVuc)
														    ->where('name', $elements[0])
														    ->where('time', date("Y-m-d H:i:s",strtotime($elements[3])))
														    ->first();
														if ($existingRecord) {	$delete = "YES";break;
														}else{ $delete="NO";break;}
										    		}
										    	}
										    }
										    if ($mov =='YES') {
											    if ($delete=="YES") {
											    	DB::table($folder_TXT)->where('time', $existingRecord->time)->delete();
											    }
											    DB::table($folder_TXT)->insert($dataToInsert);										    
												// Tách đoạn đường dẫn dựa trên dấu /
												$parts = explode('/', $file);
												// Lấy tên file
												$fileName = end($parts);
												// Loại bỏ $directoryPath khỏi đường dẫn để lấy thư mục và tên file mới
												$relativePath = str_replace($directoryPath . '/', '', $file);


												$sourcePath = storage_path('app/public/TXT/'.$folder_TXT.'/'.$relativePath);

												$destinationPath = storage_path('app/public/TXT_mov/'.$folder_TXT.'/'.$relativePath);

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

										}
										$files = Storage::files($subDirectory2);
										if (empty($files)) {
										    Storage::deleteDirectory($subDirectory2);
										    // echo "Đã xóa thư mục $subDirectory2 vì không còn file trong đó.";
										}
									}
									$directories = Storage::directories($subDirectory1);
									if (empty($directories)) {
									    Storage::deleteDirectory($subDirectory1);
									    // echo "Đã xóa thư mục $subDirectory1 vì không còn thư mục con trong đó.";
									}
								}
							}
							$directories = Storage::directories($subDirectory);
							if (empty($directories)) {
							    Storage::deleteDirectory($subDirectory);
							    // echo "Đã xóa thư mục $subDirectory1 vì không còn thư mục con trong đó.";
							}
				    	}
					}
				}
			}
    	}
    	return Redirect()->back()->withInput();}
    // xoa txt qua 3 thang
    public function resetTxt(){
    	$khuVucAll = $this->khuVucAll();
    	foreach ($khuVucAll as $key => $khuVuc) {
			$load_time = DB::table($khuVuc->folder_TXT)
			    ->select('time')
			    ->orderBy('time', 'desc')
			    ->distinct() // loai bo time trung nhau
			    ->get()
			    ->slice(25920) // Bỏ qua 25920 bản ghi đầu tiên (3 thang)
			    ->pluck('time'); // Lấy ra chỉ cột 'time' của các bản ghi còn lại
			DB::table($khuVuc->folder_TXT)
			    ->whereIn('time', $load_time) // Xóa những bản ghi có 'time'  nằm trong danh sách $load_time
			    ->delete();
    	}
    	return Redirect()->back()->withInput();}
/////////////// Time
	public function newTime($table){
		$results = DB::table($table)
		    	->select('time')
		    	->orderBy('time', 'desc')
		    	->distinct() // loai bo time trung nhau
		    	->limit(1)
		    	->get()
		    	->pluck('time');
		if (count($results)==0) {
			$results='';
		}else{
			$results = $results[0];
		}
		return $results;}
	public function timeLimit($table,$limit){
		$results = DB::table($table)
		    	->select('time')
		    	->orderBy('time', 'desc')
		    	->distinct() // loai bo time trung nhau
		    	->limit($limit)
		    	->get()
		    	->pluck('time');
		return $results;}
	public function searchTime($table,$startTime,$endTime){
		$results = DB::table($table)
		    	->select('time')
		    	->whereBetween('time', [$startTime, $endTime])
		    	->orderBy('time', 'desc')
		    	->distinct() // loai bo time trung nhau
		    	->get()
		    	->pluck('time');
		return $results;}
	public function getTxt($table,$time){
		$results = DB::table($table)
			->where('time',$time)->get();
		return $results;}

////////////////// User
	public function getNewTxtNhaMay($id_nhaMay){
		$results=[];
		$nhaMayGetId = $this->nhaMayGetId($id_nhaMay);
		$khuVuc = $this->khuVuc($id_nhaMay);
		$txt_khuVuc=[];
		foreach ($khuVuc as $key => $value) {
			$table = $value->folder_TXT;
			$id_khuVuc = $value->id_khuVuc;
			$khuVucGetId = $this->khuVucGetId($id_khuVuc);
			$alert = $this->alert($id_khuVuc);
			$newTime = $this->newTime($table);
			if ($newTime!='') {
				$getTxt = $this->getTxt($table,$newTime);
				array_push($txt_khuVuc,['khuVucGetId'=>$khuVucGetId,'alert'=>$alert,'time'=>$newTime,'getTxt'=>$getTxt]);
			}else{
				array_push($txt_khuVuc,['khuVucGetId'=>$khuVucGetId,'alert'=>$alert,'time'=>null,'getTxt'=>null]);
			}
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'txt_khuVuc'=>$txt_khuVuc]);
		// dd($results);
		return $results;}
	public function getNewTxtKhuVuc($id_khuVuc){
		$results=[];
		$khuVucGetId = $this->khuVucGetId($id_khuVuc);
		$nhaMayGetId = $this->nhaMayGetId($khuVucGetId->id_nhaMay);
		$khuVuc = $this->khuVuc($nhaMayGetId->id_nhaMay);
		$table = $khuVucGetId->folder_TXT;
		$id_khuVuc = $khuVucGetId->id_khuVuc;
		$alert = $this->alert($id_khuVuc);
		$newTime = $this->newTime($table);
		if ($newTime!='') {
			$txtNew = $this->getTxt($table,$newTime);
			$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'alert'=>$alert,'time'=>$newTime,'txtNew'=>$txtNew]);
		}else{
			$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'alert'=>$alert,'time'=>null,'txtNew'=>null]);
		}
		// dd($results);
		return $results;}
	public function getSearchTxtKhuVuc($id_khuVuc,$startTime,$endTime){
		$results=[];
		$khuVucGetId = $this->khuVucGetId($id_khuVuc);
		$table = $khuVucGetId->folder_TXT;
		$id_nhaMay = $khuVucGetId->id_nhaMay;
		$alert = $this->alert($id_khuVuc);
		$nhaMayGetId = $this->nhaMayGetId($id_nhaMay);
		$khuVuc = $this->khuVuc($id_nhaMay);

		$searchTime = $this->searchTime($table,$startTime,$endTime);
		$searchTxt = [];
		if (count($searchTime)>0) {
			foreach ($searchTime as $key => $time) {
				$getTxt = $this->getTxt($table,$time);
				array_push($searchTxt,['time'=>$time,'getTxt'=>$getTxt]);
			}
		}else{
			array_push($searchTxt,['time'=>null,'getTxt'=>null]);
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'alert'=>$alert,'khuVucGetId'=>$khuVucGetId,'searchTxt'=>$searchTxt]);
		// dd($results);
		return $results;}
	public function getLimitTxtKhuVuc($id_khuVuc,$limit){
		$results=[];
		$khuVucGetId = $this->khuVucGetId($id_khuVuc);
		$table = $khuVucGetId->folder_TXT;
		$id_nhaMay = $khuVucGetId->id_nhaMay;
		$alert = $this->alert($id_khuVuc);
		$nhaMayGetId = $this->nhaMayGetId($id_nhaMay);
		$khuVuc = $this->khuVuc($id_nhaMay);

		$timeLimit = $this->timeLimit($table,$limit);
		$searchTxt = [];
		if (count($timeLimit)>0) {
			foreach ($timeLimit as $key => $time) {
				$getTxt = $this->getTxt($table,$time);
				array_push($searchTxt,['time'=>$time,'getTxt'=>$getTxt]);
			}
		}else{
			array_push($searchTxt,['time'=>null,'getTxt'=>null]);
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'khuVucGetId'=>$khuVucGetId,'alert'=>$alert,'searchTxt'=>$searchTxt]);
		// dd($results);
		return $results;}
//////////////////  

	public function showTrangChu($id_nhaMay){
		$results = $this->getNewTxtNhaMay($id_nhaMay);
		// dd($results);
		return view('User.trangChu', compact('results'));}
	public function showKhuVuc($id_khuVuc){
		$results = $this->getLimitTxtKhuVuc($id_khuVuc,12);
		// dd($results);
		return view('User.khuVuc', compact('results'));
	}

	public function showTable($id_khuVuc){
		$results = $this->getLimitTxtKhuVuc($id_khuVuc,12);
		return view('User.table', compact('results','id_khuVuc'));
	}
	public function postShowTable(Request $request, $id_khuVuc){
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
        	$results = $this->getSearchTxtKhuVuc($id_khuVuc,$startTime,$endTime);
        	return view('User.table', compact('results','id_khuVuc','startTime','endTime'));
        }}
	public function showGraph($id_khuVuc){
		$results = $this->getLimitTxtKhuVuc($id_khuVuc,12);
		return view('User.graph', compact('results','id_khuVuc'));
	}
	public function postShowGraph(Request $request, $id_khuVuc){
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
        	$results = $this->getSearchTxtKhuVuc($id_khuVuc,$request->startTime,$request->endTime);
        	return view('User.graph', compact('results','id_khuVuc','startTime','endTime'));
        }}

	public function postExportExecel(Request $request, $id_khuVuc){
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
        	$results = $this->getSearchTxtKhuVuc($id_khuVuc,$request->startTime,$request->endTime);
			$searchTxt = $results['searchTxt'];
			$getTxt = $searchTxt[0]['getTxt'];

			$data=[];$ykeys=[];$name=['Time'];
			foreach ($getTxt as $key => $value) {
			  $name=array_merge($name,array($value->name." (".$value->unit.')'));
			}
			array_push($data, $name);
			foreach ($searchTxt as $key => $value) {
			  $time = $value['time'];
			  foreach ($value['getTxt'] as $key => $value) {
			    $ykeys = array_merge($ykeys,array('year' => $time, $value->name=>number_format($value->number,4)) );
			  }
			  array_push($data, $ykeys);
			}
			return Excel::download(new UsersExport($data), 'data.xlsx');
        }
	}

}
