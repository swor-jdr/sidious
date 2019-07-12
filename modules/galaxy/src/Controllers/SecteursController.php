<?php

namespace Modules\Galaxy\Controllers;

use App\Http\Controllers\Controller;
use Modules\Galaxy\Models\Secteur;
use Nicolasey\Personnages\Models\Personnage;

class SecteursController extends Controller
{
    /**
     * All main secteurs
     *
     * @return mixed
     */
    public function index()
    {
        return Secteur::where("parent_id", null)->get();
    }

    /**
     * Show a secteur with subsecteurs
     *
     * @param Secteur $secteur
     * @return Secteur
     */
    public function show(Secteur $secteur)
    {
        return $secteur->load("children");
    }

    /**
     * Store a new secteur
     *
     * @return mixed
     * @throws \Exception
     */
    public function store()
    {
        $data = request()->only(["name", "parent_id", "content", "image"]);

        try {
            $secteur = Secteur::create($data);
            return $secteur;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a secteur
     *
     * @param Secteur $secteur
     * @return Secteur
     * @throws \Exception
     */
    public function update(Secteur $secteur)
    {
        $data = request()->only(["name", "parent_id", "content", "image"]);

        try {
            $secteur->update($data);
            return $secteur;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Destroy a secteur (and all contents within)
     *
     * @param Secteur $secteur
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Secteur $secteur)
    {
        try {
            $secteur->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
