<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/' . env('TELEGRAM_BOT_TOKEN') . '/webhook', [TelegramController::class, 'webhook']);

Route::get('/welcome',function(){
    return view('welcome');
});
