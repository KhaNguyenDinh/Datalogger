<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alert extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'alert';
    protected $fillable = ['id_alert','id_khuVuc','name_alert','minmin','min','max','maxmax','enable'];
    protected $primaryKey = 'id_alert';
}
?>