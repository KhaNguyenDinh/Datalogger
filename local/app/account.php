<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class account extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'account';
    protected $fillable = ['id_account','id_nhaMay','name_account','pass_account'];
    protected $primaryKey = 'id_account';
}
?>