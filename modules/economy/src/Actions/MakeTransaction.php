<?php

namespace Modules\Economy\Actions;

use Modules\Economy\Events\TransactionConfirmed;
use Modules\Economy\Exceptions\TransactionNotAllowed;
use Lorisleiva\Actions\Action;
use Modules\Economy\Models\Account;
use Modules\Economy\Models\Transaction;

class MakeTransaction extends Action
{
    public $from;
    public $to;
    public $amount;
    public $motivation;

    /**
     * MakeTransaction
     *
     * @param int $amount
     * @param string $motivation
     * @param Account $to
     * @param Account|null $from
     */
    public function __construct(int $amount, string $motivation, Account $to, Account $from = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
        $this->motivation = $motivation;
        parent::__construct();
    }

    /**
     * Solvability is required to perform action
     *
     * @return boolean
     */
    public function authorize()
    {
        return $this->from->isSolvable($this->amount);
    }

    /**
     * Make a transaction
     *
     * @throws TransactionNotAllowed|\Exception
     */
    public function handle()
    {
        try {
            $transaction = Transaction::create([
                "account_from" => ($this->from) ? $this->from->id : null,
                "account_to" => $this->to->id,
                "amount" => $this->amount,
                "isCredit" => true,
                "motivation" => $this->motivation,
            ]);
            event(new TransactionConfirmed($transaction));
            return $transaction;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Respond with created transaction
     *
     * @param $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($transaction)
    {
        return response()->json($transaction);
    }
}
