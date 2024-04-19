<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vanPhong extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'vanPhong';
    protected $fillable = ['id_van_phong','name_van_phong','id_account'];
    protected $primaryKey = 'id_van_phong';

}
?>