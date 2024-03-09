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
							    $mov=''; $delete = '';
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