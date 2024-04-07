<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUser extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $user;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type,$user,$email,$password)
    {
        $this->type = $type;
        $this->user = $user;
        $this->email = $email;
        $this->password= $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->type == "add")
        {
          return $this->subject("Successful user creation.")
          ->view('mails.registroUser')
          ->with([
               "email" => $this->email,
               "password" => $this->password
          ]);
        }
        if($this->type == "edit")
        {
          return $this->subject("Successful user update.")
          ->view('mails.editUser')
          ->with([
               "user" => $this->user
          ]);
        }
    }
}
