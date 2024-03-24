<?php

namespace App;

use App\Services\CameraService;
use Illuminate\Database\Eloquent\Model;

class camera extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'camera';
    protected $fillable = ['id_camera','id_khu_vuc','name_camera','link_rtsp'];
    protected $primaryKey = 'id_camera';

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($camera) {
            // call API delete camera
            app(CameraService::class)->delete($camera->name_camera);
        });
    }
}
?>