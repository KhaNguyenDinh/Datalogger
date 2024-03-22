<?php

namespace App\Events;
use App\khuvuc;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class khuvucCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $khuvuc;

    public function __construct(khuvuc $khuvuc)
    {
        $this->khuvuc = $khuvuc;
        $tableName = str_replace(' ', '_', $khuvuc->folder_txt);

        \Schema::create($tableName, function ($table) {
            $table->increments('id');
<<<<<<< HEAD
            $table->integer('id_khu_vuc')->unsigned();
            $table->foreign('id_khu_vuc')->references('id_khu_vuc')->on('khuvuc')->onDelete('cascade');
=======
            $table->integer('id_khuVuc')->unsigned();
            $table->foreign('id_khuVuc')->references('id_khuVuc')->on('khuVuc')->onDelete('cascade');
>>>>>>> 055ea115722d8d62f9cb442bf39246714ebc4cd0
            $table->dateTime('time');
            $table->json('data');
        });
    }

}
