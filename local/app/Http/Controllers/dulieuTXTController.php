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
use App\camera;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class dulieuTXTController extends Controller
{
	//////// select
	public function nhaMay(){
		$results = nhaMay::all();
		return $results;
	}// ok
	public function nhaMayGetId($id_nhaMay){
		$results = nhaMay::find($id_nhaMay);
		return $results;
	} // ok
	public function khuVucAll(){
		$results = khuVuc::all();
		return $results;
	} //ok	
	public function khuVuc($id_nhaMay){
		$results = khuVuc::where('id_nhaMay',$id_nhaMay)->get();
		return $results;
	} // ok
	public function khuVucGetId($id_khuVuc){
		$results = khuVuc::find($id_khuVuc);
		return $results;
	} //ok
	public function alert($id_khuVuc){
		$results = alert::find($id_khuVuc);
		return $results;
	} // ok
	public function camera($id_khuVuc){
		$results = camera::find($id_khuVuc);
		return $results;
	} // ok
    // xoa txt qua 3 thang

    public function resetTxt(){
    	$khuVucAll = $this->khuVucAll();
    	foreach ($khuVucAll as $key => $khuVuc) {
    		$count = DB::table($khuVuc->folder_TXT)->count();
    		if ($count>25920) {
    			DB::table($khuVuc->folder_TXT)
			    ->orderByDesc('time')
			    ->skip(25920) // Bỏ qua 25920 bản ghi đầu tiên (3 tháng)
			    ->pluck('time')
			    ->each(function ($time) use ($khuVuc) {
			        DB::table($khuVuc->folder_TXT)
			            ->where('time', $time)
			            ->delete();
			    });
    		}
    	}
    	return Redirect()->back()->withInput();
    } //ok
/////////////// Time
	public function getNewTxt($table){
		$results = DB::table($table)
                ->orderByDesc('time')
                ->first();
		return $results;
	} // ok
	public function searchTXT($table,$startTime,$endTime){
		$results = DB::table($table)
			->whereBetween('time', [$startTime, $endTime])
			->orderByDesc('time')
            ->get();
        return $results;
	} // ok

//////////////////  
	public function loadNewTxt(Requests $request){
		dd($request);
	}

	public function showTrangChu($id_nhaMay){
		$nhaMayGetId = nhaMay::find($id_nhaMay);
		$khuVuc = khuVuc::where('id_nhaMay', $id_nhaMay)->orderBy('id_khuVuc')->get();
		$results = [];
		$result_khuVuc=[];
		foreach ($khuVuc as $key => $value) {
			$alert =alert::where('id_khuVuc', $value->id_khuVuc)->get();
			$newTxt = $this->getNewTxt($value->folder_TXT);
			array_push($result_khuVuc,['khuVucGetId'=>$value,'alert'=>$alert,'newTxt'=>$newTxt]);
		}
		$results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'result_khuVuc'=>$result_khuVuc]);
		return view('User.trangChu', compact('results'));
	} // ok
	public function dataKhuVuc($id_khuVuc, $startTime, $endTime){
		$khuVucGetId = khuVuc::find($id_khuVuc);
		$nhaMayGetId = nhaMay::find($khuVucGetId['id_nhaMay']);
		$khuVuc = khuVuc::where('id_nhaMay',$khuVucGetId['id_nhaMay'])->get();
		$alert = alert::where('id_khuVuc',$id_khuVuc)->get();
		$camera = camera::where('id_khuVuc',$id_khuVuc)->get();
		$results = []; $result_khuVuc = [];
		if ($startTime=="NO" || $endTime=="NO") {
			$txt = DB::table($khuVucGetId['folder_TXT'])
                ->orderByDesc('time')
                ->limit(12)
                ->get();
		}else{
			$txt = DB::table($khuVucGetId['folder_TXT'])
                ->orderByDesc('time')
                ->whereBetween('time', [$startTime, $endTime])
                ->get();
        }
        array_push($result_khuVuc, ['khuVucGetId'=>$khuVucGetId,'alert'=>$alert,'txt'=>$txt]);
        $results = array_merge($results,['nhaMayGetId'=>$nhaMayGetId,'khuVuc'=>$khuVuc,'camera'=>$camera,'result_khuVuc'=>$result_khuVuc]);
        return $results;
	} // ok
	public function showKhuVuc($id_khuVuc,$action){
		$results = $this->dataKhuVuc($id_khuVuc,'NO','NO');
		// dd($results);
		return view('User.khuVuc', compact('results','action'));
	}
	public function postShowKhuVuc(Request $request, $id_khuVuc,$action){
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
        	$results = $this->dataKhuVuc($id_khuVuc,$startTime,$endTime);
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
        		return view('User.khuVuc', compact('results','startTime','endTime','action'));
        	}
        }
    }


}
