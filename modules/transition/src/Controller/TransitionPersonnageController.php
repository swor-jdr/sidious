<?php
namespace Modules\Transition\Controller;

use App\Http\Controllers\Controller;
use Modules\Personnages\Models\Personnage;

class TransitionPersonnageController extends Controller
{
    /**
     * Procédure pour qu'un joueur claim un personnage existant depuis la v4
     *
     * @param Personnage $personnage
     * @return \Illuminate\Http\Response
     */
    public function claimPersonnage(Personnage $personnage)
    {
        $key = request()->input("recovery_key");
        if($personnage->recover_key === $key) {
            auth()->user()->personnages()->attach($personnage);
            $personnage->recover_key = null;
            $personnage->save();

            return response()->json();
        }
        return response()->json(null, 403);
    }
}