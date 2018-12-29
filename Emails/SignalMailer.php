<?php
/**
 * SignalMailer.php
 * Created by @anonymoussc on 02/07/2018 1:05 AM.
 */

namespace App\Components\Signal\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function build()
    {
        return $this->view('signal::email.signalmail')->with($this->emailLog);
    }
}
