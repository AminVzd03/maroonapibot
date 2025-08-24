<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public $telegram;
    public function __construct() {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }
    public function webhook(Request $request) {
        $update = $this->telegram->getWebhookUpdate();

        $chatId = $update->getMessage()->getChat()->getId();
        $text   = $update->getMessage()->getText();

        // Basic response
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text'    => "You said: {$text}"
        ]);

        info($request->all());
        return response('ok', 200);
    }
}
