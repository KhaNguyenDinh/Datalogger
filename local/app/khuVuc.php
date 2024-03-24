<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khuVuc extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'khuVuc';
    protected $dispatchesEvents = [
        'created' => \App\Events\KhuVucCreated::class,
    ];
    protected $fillable = ['id_khu_vuc','id_nha_may','name_khu_vuc','folder_txt','type','loai','link_map'];
    protected $primaryKey = 'id_khu_vuc';
}
?>
