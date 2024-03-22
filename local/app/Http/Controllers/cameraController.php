<?php
// ok
namespace App\Http\Controllers;
use App\Services\CameraService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\khuVuc;
use App\camera;

class cameraController extends Controller
{
    protected $cameraService;

    public function __construct(CameraService $cameraService)
    {
        $this->cameraService = $cameraService;
    }

    public function index($id_khuVuc){
    	$khuVuc = khuVuc::find($id_khuVuc);
    	$name = $khuVuc->name_khuVuc;
    	$id_nhaMay = $khuVuc->id_nhaMay;
	    $data = camera::where('id_khuVuc', $id_khuVuc)->orderBy('id_camera')->get();
	    return view('camera.index', compact('data', 'id_khuVuc', 'id_nhaMay' ,'name'));
    }
    public function insert($id_khuVuc){
    	return view('camera.insert', compact('id_khuVuc'));
    }
    public function postinsert(Request $request, $id_khuVuc){
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
            $check = camera::where('name_camera',$request->name_camera)->first();
            if (!$check) {
                $insert = new camera();
                $insert->id_khuVuc = $id_khuVuc;
                $insert->name_camera = $request->name_camera;
                $insert->link_rtsp = $request->link_rtsp;

                $this->cameraService->create([
                    'name' => $request->name_camera,
                    'link' => $request->link_rtsp
                ]);

                $insert->save();
            }else{
                return response()->json(['success'=>$request->name.' path/ path_new dang ton tai']);
            }
	    	return Redirect::to('Admin/camera/'.$id_khuVuc);
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
		    	'id_khuVuc' => 'required',
		        'name_camera' => 'required|min:1|max:100', // Đặt tên của trường và cung cấp quy tắc kiểm tra
		        'link_rtsp' => 'required'
		    ]
		);
        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $check = camera::where('name_camera',$request->name_camera)->where('id_camera','!=',$id_camera)->first();
            if (!$check) {
                $update = camera::query()->where('id_camera', $id_camera)->firstOrFail();

                $this->cameraService->update($update->name_camera, [
                    'name' => $request->name_camera,
                    'link' => $request->link_rtsp
                ]);

                $update->name_camera = $request->name_camera;
                $update->link_rtsp = $request->link_rtsp;

                $update->save();
            }else{
                return response()->json(['success'=>$request->name.' path/ path_new dang ton tai']);
            }

	    	return Redirect::to('Admin/camera/'.$request->id_khuVuc);
        }
    }
    public function delete($id_camera){
    	$data = camera::query()->where('id_camera', $id_camera)->firstOrFail();
        $this->cameraService->delete($data->name_camera);
    	$data->delete();
        return Redirect()->back()->withInput();
    }

}
