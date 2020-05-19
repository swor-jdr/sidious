<?php
namespace Modules\Economic\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Economy\Events\TransactionOrder;
use Modules\Economy\Models\Account;

class ProcessEconomicTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $motivation;
    public $amount;
    public $to;
    public $from;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $motivation, int $amount, Account $to, Account $from = null)
    {
        $this->motivation = $motivation;
        $this->amount = $amount;
        $this->to = $to;
        $this->from = $from;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event(new TransactionOrder($this->amount, $this->motivation, $this->to, $this->from));
    }
}
