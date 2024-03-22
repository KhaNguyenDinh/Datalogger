<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khuvuc extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'khuvuc';
    protected $dispatchesEvents = [
        'created' => \App\Events\khuvucCreated::class,
    ];
    protected $fillable = ['id_khu_vuc','id_nha_may','name_khu_vuc','folder_txt','type','loai','link_map'];
    protected $primaryKey = 'id_khu_vuc';
}
?>
