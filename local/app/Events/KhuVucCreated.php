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
        $tableName = str_replace(' ', '_', $khuVuc->folder_TXT);

        \Schema::create($tableName, function ($table) {
            $table->increments('id');
            $table->integer('id_khuVuc')->unsigned();
            $table->foreign('id_khuVuc')->references('id_khuVuc')->on('khuVuc')->onDelete('cascade');
            $table->dateTime('time')->unique();
            $table->json('data')->unique();
        });
    }

}
