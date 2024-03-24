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

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($nhaMay) {
            $listKhuVuc = khuVuc::query()
                ->where('id_nha_may', $nhaMay->id_nha_may)
                ->get();

            foreach ($listKhuVuc as $item) {
                $item->delete();
            }
        });
    }
}
?>