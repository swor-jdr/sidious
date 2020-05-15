<?php
namespace Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Modules\Economy\Models\Account;

class AccountController extends Controller
{
    /**
     * Get account & all transactions
     *
     * @param Account $account
     * @return Collection
     */
    public function show(Account $account)
    {
        $account->load("from", "to");
        $transactions = new Collection([$account->from, $account->to]);
        $transactions->sortBy('created_at');
        return $transactions;
    }

    public function transfer()
    {
        //
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
