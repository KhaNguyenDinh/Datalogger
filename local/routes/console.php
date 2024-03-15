<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('log_db', function () {
	app(App\Services\LogService::class)->loadTxtAll();
})->describe('Display an inspiring quote');

Artisan::command('reset_db', function () {
	app(App\Services\LogService::class)->resetTxt();
})->describe('Display an inspiring quote');