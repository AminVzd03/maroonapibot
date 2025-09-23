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

    public function sendMessage($chat_id,$view, string $data = null, array $buttons = [])
    {
        $text =  view($view, compact('data'))->render();
        info($text);

        $url = 'https://api.telegram.org/bot' . $this->token . '/sendMessage';
        $payload = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML',
        ];
        $keyboard = $this->buildInlineKeyboard($buttons);
        if ($keyboard) {
            $payload['reply_markup'] = json_encode($keyboard);
        }
        Http::post($url, $payload);
    }

    private function buildInlineKeyboard(array $buttons): ?array
    {
        if (empty($buttons)) {
            return null;
        }
        $keyboard = [];
        foreach ($buttons as $button) {
            $keyboard[] = [
                'text' => $button['text'],
                'callback_data' => $button['callback_data'],
            ];
        }
        return ['inline_keyboard' => [$keyboard]];
    }
}
