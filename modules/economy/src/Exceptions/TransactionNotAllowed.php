<?php

namespace Modules\Economy\Exceptions;

use Exception;

class TransactionNotAllowed extends Exception
{
    public function render()
    {
        // @todo change for wrong parameters http code
        return response()->json("Transaction not allowed", 403);
    }
}
