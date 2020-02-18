<?php
namespace Modules\Inventory\Traits;

use Modules\Inventory\Models\Possession;

trait HasInventory
{
    public function possessions()
    {
        return $this->morphMany(Possession::class, "owner");
    }
}
