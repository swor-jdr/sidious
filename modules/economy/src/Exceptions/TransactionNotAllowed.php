<?php

namespace Modules\Ecoomy\Exceptions;

use Exception;

class TransactionNotAllowed extends Exception
{
    public function render()
    {
        // @todo change for wrong parameters http code
        return response()->json("Transaction not allowed", 403);
    }
}
