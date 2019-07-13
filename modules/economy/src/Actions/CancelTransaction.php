<?php

namespace App\Actions;

use Lorisleiva\Actions\Action;
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
            Transaction::findOrFail($this->get("transaction_id"))->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function response()
    {
        return response()->json();
    }
}
