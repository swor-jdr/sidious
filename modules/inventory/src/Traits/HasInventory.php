<?php
namespace Modules\Inventory\Traits;

use Modules\Inventory\Models\Possession;

trait HasInventory
{
    public function things()
    {
        return $this->morphMany(Possession::class, "owner");
    }
}