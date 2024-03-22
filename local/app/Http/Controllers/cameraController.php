<?php
// ok
namespace App\Http\Controllers;
use App\Services\CameraService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\khuvuc;
use App\camera;

class cameraController extends Controller
{
    protected $cameraService;

    public function __construct(CameraService $cameraService)
    {
        $this->cameraService = $cameraService;
    }

    public function index($id_khu_vuc){
    	$khuvuc = khuvuc::find($id_khu_vuc);
    	$name = $khuvuc->name_khu_vuc;
    	$id_nha_may = $khuvuc->id_nha_may;
	    $data = camera::where('id_khu_vuc', $id_khu_vuc)->orderBy('id_camera')->get();
	    return view('camera.index', compact('data', 'id_khu_vuc', 'id_nha_may' ,'name'));
    }
    public function insert($id_khu_vuc){
    	return view('camera.insert', compact('id_khu_vuc'));
    }
    public function postinsert(Request $request, $id_khu_vuc){
		$validator = Validator::make(
		    $request->all(),
		    [
		        'name_camera' => 'required|min:1|max:100',
		        'link_rtsp' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$insert = new camera();
	    	$insert->id_khu_vuc = $id_khu_vuc;
	    	$insert->name_camera = $request->name_camera;
	    	$insert->link_rtsp = $request->link_rtsp;

            $this->cameraService->create([
                'name' => $request->name_camera,
                'link' => $request->link_rtsp
            ]);

	    	$insert->save();
	    	return Redirect::to('Admin/camera/'.$id_khu_vuc);
        }
    }
    public function update($id_camera){
    	$data = camera::find($id_camera);
    	return view('camera.update')->with(compact('data'));
    }
    public function postupdate(Request $request, $id_camera){
		$validator = Validator::make(
		    $request->all(),
		    [
		    	'id_khu_vuc' => 'required',
		        'name_camera' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'link_rtsp' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
	    	$update = camera::query()->where('id_camera', $id_camera)->firstOrFail();

            $this->cameraService->update($update->name_camera, [
                'name' => $request->name_camera,
                'link' => $request->link_rtsp
            ]);

            $update->name_camera = $request->name_camera;
            $update->link_rtsp = $request->link_rtsp;

	    	$update->save();
	    	return Redirect::to('Admin/camera/'.$request->id_khu_vuc);
        }
    }
    public function delete($id_camera){
    	$data = camera::query()->where('id_camera', $id_camera)->firstOrFail();
        $this->cameraService->delete($data->name_camera);
    	$data->delete();
        return Redirect()->back()->withInput();
    }

}
