<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * order 实例。
     *
     * @var Order
     */
    public $data;

    /**
     * 创建一个新消息实例。
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 构建消息。
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Rema API 異常")->view('emails.email')->with([
            'name'       => $this->data['name'],
            'input_data' => $this->data['input_data'],
            'status'     => $this->data['status'],
            'message1'    => $this->data['message']
        ]);

    }
}