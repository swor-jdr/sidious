<?php

namespace Modules\Economy\Actions;

use Lorisleiva\Actions\Action;
use Modules\Economy\Events\TransactionCancelled;
use Modules\Economy\Models\Transaction;

class CancelTransaction extends Action
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "transaction_id" => "required"
        ];
    }

    /**
     * Cancel transaction by deleting it
     *
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $transaction = Transaction::findOrFail($this->get("transaction_id"))->delete();
            event(new TransactionCancelled($transaction));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function response()
    {
        return response()->json();
    }
}
