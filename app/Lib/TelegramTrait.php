<?php

namespace App\Lib;

/**
 * Trait wrapper for Telegram message
 * 
 */
trait TelegramTrait
{
    /**
     * This method send to Telegram order.
     * 
     * @param string $messageText
     * @return void
     */
    private function sendMessageToTelegram(string $messageText):void
    {
        $t = new \Telegram(env('TELEGRAM_TOKEN'));
        $t->sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $messageText
        ]);
    }
}