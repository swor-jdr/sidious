<?php
namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Models\ObjectType;

class ObjectTypeController extends Controller
{
    public function index()
    {
        return ObjectType::all();
    }

    /**
     * Store an object type
     *
     * @return mixed
     * @throws \Exception
     */
    public function store()
    {
        $data = request()->only("name");

        try {
            $type = ObjectType::create($data);
            return $type;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Show object type with objects
     *
     * @param ObjectType $objectType
     * @return ObjectType
     */
    public function show(ObjectType $objectType)
    {
        return $objectType->load("objects");
    }

    /**
     * Update object type
     *
     * @param ObjectType $objectType
     * @return ObjectType
     * @throws \Exception
     */
    public function update(ObjectType $objectType)
    {
        $data = request()->only("name");

        try {
            $objectType->update($data);
            return $objectType;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete object type
     *
     * @param ObjectType $objectType
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ObjectType $objectType)
    {
        try {
            $objectType->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
