<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class viTri extends Model
{
   	public $timestamps = false;
    protected $keyType = 'string';
    protected $table = 'vitri';
    protected $fillable = ['id','id_khu_vuc','name','vitri'];
    protected $primaryKey = 'id';
}
?>