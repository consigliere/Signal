<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/18/19 11:15 AM
 */

/**
 * SignalMailer.php
 * Created by @anonymoussc on 02/07/2018 1:05 AM.
 */

namespace App\Components\Signal\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SignalMailer
 * @package App\Components\Signal\Emails
 */
class SignalMailer extends Mailable
{
    use Queueable, SerializesModels;

    protected $emailLog;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->emailLog = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->view('signal::email.signalmail')->with($this->emailLog);
    }
}
