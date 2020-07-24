<?php
namespace Modules\Personnages\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Modules\Personnages\Events\PersonnageActivated;
use Modules\Personnages\Events\PersonnageCreated;
use Modules\Personnages\Events\PersonnageDeactivated;
use Modules\Personnages\Events\PersonnageKilled;
use Modules\Personnages\Events\PersonnageResurrected;
use Modules\Personnages\Events\PersonnageUpdated;
use Modules\Personnages\Models\Personnage;
use DB;

class PersonnageController extends Controller
{
    protected $fields = ["name", "bio", "signature", "aversions", "affections", "job", "title", "hide", "owner_id", "location"];

    /**
     * Get all personnages
     *
     * @return \Illuminate\Database\Eloquent\Collection|Personnage[]|LengthAwarePaginator
     */
    public function index()
    {
        $limit = request("limit") || 10;

        $all = Personnage::with(['owner', 'tags'])
            ->when(request()->has('search'), function ($q) {
                $q->where('name', 'LIKE', '%' . request('search') . '%');
            })
            ->when(request('orderBy'), function ($q, $value) {
                $q->orderBy($value, 'DESC');
            })
            ->when(request('active'), function ($q, $value) {
                $q->active(true);
            })
            ->when(request('staff'), function ($q, $value) {
                $q->staff(true);
            })
            ->when(request('alive'), function ($q, $value) {
                $q->alive($value);
            });

        return (request()->has("page")) ? $all->paginate($limit) : $all->get();
    }

    /**
     * Get all personnages from an owner
     *
     * @param int $id
     * @return mixed
     */
    public function byOwnerActive(int $id)
    {
        return Personnage::of($id)->active(true)->get();
    }

    /**
     * Get all personnages from an owner
     *
     * @param int $id
     * @return mixed
     */
    public function byOwner(int $id)
    {
        return Personnage::of($id)->get();
    }

    /**
     * Show a personnage
     *
     * @param Personnage $personnage
     * @return Personnage
     */
    public function show(Personnage $personnage)
    {
        return $personnage->load("owner", "account", "fiche");
    }

    /**
     * Create a personnage
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store()
    {
        $data = request()->only($this->fields);

        try {
            $personnage = Personnage::create($data);

            /**
             * If there is an avatar, attach it to newly created personnage
             */
            if(request()->hasFile("avatar")) {
                $personnage->addMediaFromRequest('avatar')->toMediaCollection('avatar');
                $thumb = $personnage->getMedia('avatar')->first()->getUrl('thumb');
                $regular = $personnage->getMedia('avatar')->first()->getUrl('regular');

                $personnage->avatar_tiny = $thumb;
                $personnage->avatar_regular = $regular;
                $personnage->save();
            }

            event(new PersonnageCreated($personnage));
            return response()->json($personnage);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a personnage
     *
     * @param Personnage $personnage
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Personnage $personnage)
    {
        $data = request()->only($this->fields);

        try {
            $personnage->update($data);

            event(new PersonnageUpdated($personnage));
            return response()->json($personnage);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a personnage
     *
     * @param Personnage $personnage
     * @throws \Exception
     * @return void
     */
    public function destroy(Personnage $personnage): void
    {
        try {
            $personnage->delete();

            if($personnage->current) {
                $personnage->setCurrent(false);

                $otherPersonnages = $personnage->owner->personnages->filter(function($item) use($personnage) {
                    return $item->id !== $personnage->id;
                });

                if($otherPersonnages) $otherPersonnages->first()->setCurrent(true);
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Activate personnage
     *
     * @param Personnage $personnage
     * @return Personnage
     * @throws \Exception
     */
    public function activate(Personnage $personnage)
    {
        try {
            $personnage->update(['active' => true]);

            event(new PersonnageActivated($personnage));
            return $personnage;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deactivate personnage
     *
     * @param Personnage $personnage
     * @return Personnage
     * @throws \Exception
     */
    public function deactivate(Personnage $personnage)
    {
        try {
            $personnage->update(['active' => false]);

            event(new PersonnageDeactivated($personnage));
            return $personnage;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Kill a personnage
     *
     * @param Personnage $personnage
     * @return Personnage
     * @throws \Exception
     */
    public function kill(Personnage $personnage)
    {
        try {
            Personnage::unguard();
            $personnage->update(['alive' => false, 'active' => false]);
            Personnage::reguard();

            event(new PersonnageKilled($personnage));
            return $personnage;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Resurrect a personnage
     *
     * @param Personnage $personnage
     * @return Personnage
     * @throws \Exception
     */
    public function resurrect(Personnage $personnage)
    {
        try {
            Personnage::unguard();
            $personnage->update(['alive' => true, 'active' => false]);
            Personnage::reguard();

            $this->changeTo($personnage);

            event(new PersonnageResurrected($personnage));
            return $personnage;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Personnage switch (in case owner has several)
     *
     * @param Personnage $personnage
     * @throws \Exception
     */
    public function changeTo(Personnage $personnage)
    {
        DB::beginTransaction();
        try {
            $personnages = $personnage->owner->personnages;
            foreach ($personnages as $pj) $pj->setActive(false);

            $personnage->setActive(true);
            DB::commit();
            event(new PersonnageActivated($personnage));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
