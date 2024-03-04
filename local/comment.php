creat table 

1, php artisan make:listener CreateTableFromKhuVuc --event=App\Events\KhuVucCreated
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
            $table->increments('id_dl');
            $table->integer('id_khuVuc')->unsigned();
            $table->foreign('id_khuVuc')->references('id_khuVuc')->on('khuVuc')->onDelete('cascade');
            $table->string('name');
            $table->float('number');
            $table->string('unit');
            $table->DATETIME('time');
            $table->integer('status');
        });
    }

}
?>
2, app/Providers/EventServiceProvider.php 

<?php 
protected $listen = [
    'App\Events\KhuVucCreated' => [
        'App\Listeners\CreateTableFromKhuVuc',
    ],
];
 ?>
3, php artisan make:listener CreateTableFromKhuVuc --event=CreateTableFromKhuVuc

<?php 
namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTableFromKhuVuc
{

    public function handle($event)
    {
        //
    }
}
 ?>
