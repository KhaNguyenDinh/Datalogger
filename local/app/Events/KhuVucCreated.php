<?php

namespace App\Events;
use App\KhuVuc;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KhuVucCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $khuVuc;

    public function __construct(KhuVuc $khuVuc)
    {
        $this->khuVuc = $khuVuc;
        $tableName = str_replace(' ', '_', strtolower($khuVuc->folder_txt));

        \Schema::create($tableName, function ($table) {
            $table->increments('id');
            $table->integer('id_khu_vuc')->unsigned()->index();
            $table->dateTime('time')->index();
            $table->json('data');
        });
    }

}
