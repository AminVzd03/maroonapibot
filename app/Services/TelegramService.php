<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
class TelegramService
{
    public $token;
    public function __construct()
    {
        $this->token = config('services.telegram.token');
    }
    public function getUpdates($offset = 0, $timeout = 30){
        $url = 'https://api.telegram.org/bot'.$this->token.'/getUpdates';
        $response =  Http::timeout($timeout + 5)->get($url,[
            'offset' => $offset,
        ]);
        return $response->json();
    }
    public function sendMessage($chat_id , $text){
        $url = 'https://api.telegram.org/bot'.$this->token.'/sendMessage';
        $response = Http::post($url,[
            'chat_id' => $chat_id,
            'text' => $text,
        ]);
        //return $response->json();
    }
}
