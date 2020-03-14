<?php
namespace Modules\Transition\Controllers;

use App\Http\Controllers\Controller;
use Modules\Personnages\Models\Personnage;
use Illuminate\Support\Facades\Auth;
use Modules\Transition\Models\TransitionUser;

class TransitionPersonnageController extends Controller
{
    /**
     * Procédure pour qu'un joueur claim un personnage existant depuis la v4
     *
     * @param Personnage $personnage
     * @return \Illuminate\Http\JsonResponse
     */
    public function claimPersonnage(Personnage $personnage)
    {
        $key = request()->input("recovery_key");
        if($personnage->recover_key === $key) {
            Auth::user()->personnages()->attach($personnage);
            $personnage->recover_key = null;
            $personnage->save();

            return response()->json();
        }
        return response()->json(null, 403);
    }

    public function users()
    {
        return TransitionUser::find(2);
    }
}
