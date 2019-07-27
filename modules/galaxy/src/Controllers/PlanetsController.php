<?php
namespace Modules\Galaxy\Controllers;

use App\Http\Controllers\Controller;
use Modules\Galaxy\Models\Planet;
use Modules\Galaxy\Models\Secteur;
use Nicolasey\Personnages\Models\Personnage;

class PlanetsController extends Controller
{
    /**
     * All planets in a given secteur
     *
     * @param Secteur $secteur
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Secteur $secteur)
    {
        return $secteur->planets()->get();
    }

    /**
     * Show a planet within its secteur
     *
     * @param Secteur $secteur
     * @param Planet $planet
     * @return Planet
     */
    public function show(Secteur $secteur, Planet $planet)
    {
        $planet->secteur = $secteur; // fill in info without further requests
        return $planet;
    }

    /**
     * Store a new planet
     *
     * @param Secteur $secteur
     * @return mixed
     * @throws \Exception
     */
    public function store(Secteur $secteur)
    {
        $data = request()->only(["name", "content", "image", "type"]);

        try {
            $planet = $secteur->planets()->create($data);
            return $planet;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a planet
     *
     * @param Secteur $secteur
     * @param Planet $planet
     * @return Planet
     * @throws \Exception
     */
    public function update(Secteur $secteur, Planet $planet)
    {
        $data = request()->only(["name", "content", "image", "type", "secteur_id"]);

        // We do not trust any source
        $planetMoves = (!empty($data['secteur_id']));
        if($planetMoves) $newSecteur = Secteur::findOrFail($data['secteur_id']);

        try {
            $planet->update($data);
            return $planet;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a planet
     *
     * @param Secteur $secteur
     * @param Planet $planet
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Secteur $secteur, Planet $planet)
    {
        try {
            $planet->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Add a manager
     *
     * @param Planet $planet
     * @param Personnage $personnage
     * @throws \Exception
     */
    public function setAsManager(Planet $planet, Personnage $personnage)
    {
        try {
            $planet->managers()->attach($personnage);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Add a manager
     *
     * @param Planet $planet
     * @param Personnage $personnage
     * @throws \Exception
     */
    public function removeAsManager(Planet $planet, Personnage $personnage)
    {
        try {
            $planet->managers()->detach($personnage);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
