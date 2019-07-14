<?php

namespace Modules\Economy\Actions;

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
            "isCredit" => "required|boolean"
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
        if(!$from->account->canPay($this->get("amount"))) {
            throw new TransactionNotAllowed("Not enough funds");
        }

        /*
         * PROCEED
         */
        try {
             return Transaction::create([
                "from" => ($from) ? $from->id : null,
                "to" => $to->id,
                "amount" => $this->get("amount"),
                "isCredit" => $this->get("isCredit")
            ]);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function response($transaction)
    {
        return response()->json($transaction);
    }
}
