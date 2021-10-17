<?php

namespace App\Mail;

use App\Lib\TelegramTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCart extends Mailable
{
    use Queueable, SerializesModels, TelegramTrait;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $param;
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->sendToTelegram();
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Ваш заказ оформлен')
            ->markdown('emails.orderCart')
            ->with($this->param);
    }

    /**
     * Send info in Telegram.
     *
     */
    private function sendToTelegram(): void
    {
        $text = "Заказана группа товаров.\n";
        foreach ($this->param['products'] as $p) {
            $text .= "{$p->product->title} {$p->size} {$p->product->price}x{$p->count}\n";
        }
        $text .= "Полная сума заказа: {$this->param['fullPrice']}.\n";
        $text .= "Телефон: {$this->param['phone']}.\n";
        $this->sendMessageToTelegram($text);
    }
}
