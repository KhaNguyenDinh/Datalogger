<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'role';
    protected $fillable = ['id','id_nha_may','id_van_phong'];
    protected $primaryKey = 'id';

}
?>