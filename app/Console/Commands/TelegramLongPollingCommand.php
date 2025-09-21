<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class TelegramLongPollingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'longpolling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the long polling for the telegram bot';
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        Parent::__construct();
        $this->telegram = $telegram;
    }

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $offset = 0;

        $this->info("Starting Telegram long polling...");
        $buttons = [
                ['text' => "Start", 'callback_data' => "start"],
                ['text' => "Stop", 'callback_data' => "stop"],

        ];
        while (true) {
            $updates = $this->telegram->getUpdates($offset);
            if (isset($updates['result'])) {
                foreach ($updates['result'] as $update) {
                    $offset = $update['update_id'] + 1;
                    if (isset($update['message'])) {
                        $chat_id = $update['message']['chat']['id'];
                        $text = $update['message']['text'];
                        $this->telegram->sendMessage( $chat_id, view: 'chooseSource',data:$update['message'] , buttons:  $buttons);
                    }
                }
            }
            sleep(1);
        }
    }
}
