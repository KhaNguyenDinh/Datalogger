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
    protected $fillable = ['id_khuVuc','id_nhaMay','name_khuVuc','folder_TXT','type'];
    protected $primaryKey = 'id_khuVuc';
}
?>
