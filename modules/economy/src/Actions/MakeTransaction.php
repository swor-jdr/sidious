<?php

namespace Modules\Economy\Actions;

use App\Exceptions\TransactionNotAllowed;
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
            "from" => "required|integer",
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
        $from = Account::findOrFail($this->get("from"));
        $to = Account::findOrFail($this->get("to"));
        if($this->get('amount') < 0) throw new TransactionNotAllowed();
        if($from->account->balance < $this->get("amount") throw new TransactionNotAllowed("Solde insuffisant");

        /*
         * PROCEED
         */
        try {
             return Transaction::create([
                "from" => ,
                "to" => ,
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
