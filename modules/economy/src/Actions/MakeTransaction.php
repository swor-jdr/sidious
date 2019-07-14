<?php

namespace Modules\Economy\Actions;

use Modules\Economy\Events\TransactionConfirmed;
use Modules\Economy\Exceptions\TransactionNotAllowed;
use Lorisleiva\Actions\Action;
use Modules\Economy\Models\Account;
use Modules\Economy\Models\Transaction;

class MakeTransaction extends Action
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "from" => "integer",
            "to" => "required|integer",
            "amount" => "required|integer",
            "isCredit" => "required|boolean",
            "motivation" => "required|string|min:3"
        ];
    }

    /**
     * Make a transaction
     *
     * @throws TransactionNotAllowed|\Exception
     */
    public function handle()
    {
        /*
         * CHECKS
         */
        $from = ($this->get("from")) ? Account::find($this->get("from")) : null;
        $to = Account::findOrFail($this->get("to"));
        if($this->get('amount') < 0) throw new TransactionNotAllowed();
        if($from) {
            if(!$from->canPay($this->get("amount"))) throw new TransactionNotAllowed("Not enough funds");
        }

        /*
         * PROCEED
         */
        try {
            $transaction = Transaction::create([
                "account_from" => ($from) ? $from->id : null,
                "account_to" => $to->id,
                "amount" => $this->get("amount"),
                "isCredit" => $this->get("isCredit"),
                "motivation" => $this->get("motivation")
            ]);
            event(new TransactionConfirmed($transaction));
            return $transaction;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function response($transaction)
    {
        return response()->json($transaction);
    }
}
