<?php
namespace Modules\Transition\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Personnages\Models\Personnage;

class RecoverPersonnage extends Mailable
{
    use Queueable, SerializesModels;

    public $personnage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Personnage $personnage)
    {
        $this->personnage = $personnage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('modules::transition.emails.recover');
    }
}
