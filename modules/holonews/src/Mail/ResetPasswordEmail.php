<?php

namespace Modules\Holonews\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordEmail extends Mailable
{
    /**
     * The token for the reset.
     *
     * @var string
     */
    public $token;

    /**
     * New instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Changez votre mot de passe...')
            ->view('holonews::emails.password', [
                'link' => route('holonews.password.reset', ['token' => $this->token]),
            ]);
    }
}
