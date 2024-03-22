<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nhamay extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'nhamay';
    protected $fillable = ['id_nha_may','name_nha_may'];
    protected $primaryKey = 'id_nha_may';
}
?>