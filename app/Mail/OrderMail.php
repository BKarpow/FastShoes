<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Lib\TelegramTrait;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels, TelegramTrait;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private array $param;
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
        return $this->subject('Заказан товар')
                    ->from(env('MAIL_FROM_ADDRESS'))
                    ->markdown('emails.ordermail')
                    ->with($this->param);
    }

    /**
     * Send info in Telegram
     * 
     */
    private function sendToTelegram():void
    {
        $text = "Заказан товар {$this->param['product']->title}.\n";
        $text .= "Размер: {$this->param['size']}.\n";
        $text .= "Цена: {$this->param['price']}.\n";
        $text .= "Куда звонить: {$this->param['phone']}\n";
        $text .= "Общаться через мессенджеры: {$this->param['useMessage']}.\n";
        $text .= "Товар: {$this->param['product']->uri()}\n";
        $this->sendMessageToTelegram($text);
    }
}
