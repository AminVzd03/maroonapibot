<?php

namespace App\Services;

use App\BotStatesEnum;


class ConversationService
{
    public int $chat_id;
    public string $text;

    public function __construct(protected TelegramService $telegram){ }


    public function handleStates($chat_id, $text): void
    {
        $this->handleStart($chat_id, $text);
    }

    public function handleStart($chat_id, $text)
    {
        if ($text = BotStatesEnum::START) {
            return $this->telegram->sendMessage($chat_id, view: "start");
        }
    }
}
