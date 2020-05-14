<?php
namespace Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use Modules\Economy\Models\Fiche;
use Modules\Personnages\Models\Personnage;

class FicheController extends Controller
{
    /**
     * Get fiche from pj
     *
     * @param Personnage $personnage
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function show(Personnage $personnage)
    {
        return Fiche::with("")->where([
            "owner_type" => Personnage::class,
            "owner_id" => $personnage->id,
        ])->first();
    }
}
