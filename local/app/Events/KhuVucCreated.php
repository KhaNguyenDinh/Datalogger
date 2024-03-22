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
            $table->integer('id_khu_vuc')->unsigned();
            $table->foreign('id_khu_vuc')->references('id_khu_vuc')->on('khuvuc')->onDelete('cascade');
            $table->dateTime('time');
            $table->json('data');
        });
    }

}
