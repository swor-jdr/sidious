<?php
namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Contracts\HasInventoryContract;
use Modules\Inventory\Models\Possession;

class PossessionController extends Controller
{
    public function show()
    {
        
    }

    public function add()
    {
        //
    }

    public function remove()
    {

    }

    private function getInventoryFrom(HasInventoryContract $contractor)
    {
        return Possession::where([[
            "owner_id" => $contractor->id,
            "owner_type" => get_class($contractor),
        ]])->all();
    }
}
