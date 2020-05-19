<?php
namespace Modules\Economy\Events;

use Modules\Economy\Models\Account;
use Modules\Personnages\Events\Event;

class TransactionOrder extends Event
{
    public $from;
    public $to;
    public $amount;
    public $motivation;

    public function __construct(int $amount, string $motivation, Account $to, Account $from = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
        $this->motivation = $motivation;
    }
}
