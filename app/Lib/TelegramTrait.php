<?php

namespace App\Lib;

use App\Models\Product;

/**
 * Trait wrapper for Telegram message
 *
 */
trait TelegramTrait
{
    /**
     * This method send to Telegram order (service group).
     *
     * @param string $messageText
     * @return void
     */
    private function sendMessageToTelegram(string $messageText): void
    {
        $t = new \Telegram(env('TELEGRAM_TOKEN'));
        $t->sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $messageText,
        ]);
    }

    /**
     * Send message to Telegram chanel
     *
     * @param string $message
     * @return void
     */
    private function sendToTelegramChanel(string $message): void
    {
        $t = new \Telegram(env('TELEGRAM_TOKEN'));
        $t->sendMessage([
            'chat_id' => env('TELEGRAM_CHANEL_CHAT_ID'),
            'text' => $message,
        ]);

    }

    /**
     * Sent Product info to chanel
     *
     * @param Product $product
     * @return void
     */
    private function sendInfoProductToChanelTelegram(Product $product): void
    {
        $text = "Новый товар в магазине.\n";
        $text .= "{$product->category->section->title},{$product->category->title}\n";
        $text .= "Цена: {$product->price} грн.\n";
        $text .= " {$product->uri()}\n";
        $this->sendToTelegramChanel($text);
    }

}
