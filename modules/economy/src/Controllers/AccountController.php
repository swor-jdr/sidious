<?php
namespace Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Modules\Economy\Actions\MakeTransaction;
use Modules\Economy\Contracts\EconomicActor;
use Modules\Economy\Exceptions\TransactionNotAllowed;
use Modules\Economy\Models\Account;
use Modules\Economy\Models\Transaction;

class AccountController extends Controller
{
    /**
     * Get account & all transactions
     *
     * @param Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Account $account)
    {
        $account->load("from", "to");
        $transactions = new Collection([$account->from, $account->to]);
        $transactions->sortBy('created_at');
        return response()->json(["account" => $account, "transactions" => $transactions]);
    }

    /**
     * Make a transaction between accounts
     *
     * @param EconomicActor $from
     * @param EconomicActor $to
     * @param int $amount
     * @param string $motivation
     * @return mixed
     * @throws TransactionNotAllowed
     */
    private function transfer(EconomicActor $from, EconomicActor $to, int $amount, string $motivation)
    {
        try {
            // an action should be here but is not
        } catch (\Exception $exception) {}
    }

    /**
     * Freeze an account
     *
     * @param Account $account
     * @return Account
     */
    public function freeze(Account $account)
    {
        $account->isFrozen = true;
        $account->save();
        return $account;
    }
}
