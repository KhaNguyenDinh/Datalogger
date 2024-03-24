<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nhaMay extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'nhaMay';
    protected $fillable = ['id_nha_may','name_nha_may'];
    protected $primaryKey = 'id_nha_may';
}
?>