<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = [
            "url" => url("https://techfinder.vichea.xyz/reset-password/" . $data["token"]),
            "name" => $data["full_name"],
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("noreply@gmail.com", "Tech Finding")
            ->markdown('emails.reset_password_email')->with(["data" => $this->data]);
    }
}
