<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nhaMay extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'nhaMay';
    protected $fillable = ['id_nhaMay','name_nhaMay'];
    protected $primaryKey = 'id_nhaMay';
}
?>