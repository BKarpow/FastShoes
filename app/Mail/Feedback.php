<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Lib\TelegramTrait;

class Feedback extends Mailable
{
    use Queueable, SerializesModels,TelegramTrait;

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
        return $this->subject('Сообщения из сайта')
        ->from(env('MAIL_FROM_ADDRESS'))
        ->markdown('emails.feedback')
        ->with($this->param);
    }


    /**
     * Send info in Telegram
     * 
     */
    private function sendToTelegram():void
    {
        $text = "Сообщения на сайте.\n";
        $text .= "Email: {$this->param['feedback']->email}.\n";
        $text .= "Feedback ID: {$this->param['feedback']->id}.\n";
        $text .= "Сообщения:\n";
        $text .= "{$this->param['feedback']->message}";
        $this->sendMessageToTelegram($text);
    }
}
