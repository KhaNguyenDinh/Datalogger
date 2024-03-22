<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class camera extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'camera';
    protected $fillable = ['id_camera','id_khu_vuc','name_camera','link_rtsp'];
    protected $primaryKey = 'id_camera';
}
?>