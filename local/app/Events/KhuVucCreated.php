<?php

namespace App\Events;
use App\KhuVuc;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
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
            $table->integer('id_khu_vuc')->unsigned();
            $table->foreign('id_khu_vuc')->references('id_khu_vuc')->on('khuVuc')->onDelete('cascade');
            $table->dateTime('time');
            $table->json('data');
        });
    }

}
