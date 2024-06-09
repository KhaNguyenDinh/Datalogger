<?php

namespace App;

use App\Services\mailService;
use Illuminate\Database\Eloquent\Model;

class email extends Model
{
   	public $timestamps = true;
    protected $keyType = 'string';
    protected $table = 'mail';
    protected $fillable = ['id','id_nha_may','email'];
    protected $primaryKey = 'id';
}
?>