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

    public function getUpdates($offset = 0, $timeout = 30)
    {
        $url = 'https://api.telegram.org/bot' . $this->token . '/getUpdates';
        $response = Http::timeout($timeout + 5)->get($url, [
            'offset' => $offset,
        ]);
        return $response->json();
    }

    public function sendMessage($chat_id, $text,array $buttons = [] )
    {

        $url = 'https://api.telegram.org/bot' . $this->token . '/sendMessage';
        $payload = Http::post($url, [
            'chat_id' => $chat_id,
            'text' => $text,
        ]);
        $keyboard = $this->buildInlineKeyboard($buttons);
        if($keyboard) {
            $payload['reply_markup'] = json_encode($keyboard);
        }
        //return $response->json();
    }
    private function buildInlineKeyboard( array $buttons) : ?array {
        if (empty($buttons)) {
            return null;
        }
        $keyboard = [];
        if (isset($buttons[0]['text'])) {
            $buttons = [$buttons];
        }
        foreach ($buttons as $row) {
            $rowButtons =[];
            foreach ($row as $button) {
                   $rowButtons [] = [
                    'text' => $button['text'],
                    'callback_data' => $button['callback_data']
                ];
            }
            $keyboard [] = $rowButtons;

        }
        return ['inline_keyboard' => $keyboard];
    }
}
