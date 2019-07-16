<?php
namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Models\Object;
use Modules\Inventory\Models\ObjectType;

class ObjectController extends Controller
{
    /**
     * List all objects of that type
     *
     * @param ObjectType $objectType
     * @return ObjectType
     */
    public function index(ObjectType $objectType)
    {
        return $objectType->load("objects");
    }

    /**
     * Show object
     *
     * @param ObjectType $objectType
     * @param Object $object
     * @return Object
     */
    public function show(ObjectType $objectType, \Modules\Inventory\Models\Object $object)
    {
        $object->type = $objectType;
        return $object;
    }

    /**
     * Add an object
     *
     * @param ObjectType $objectType
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function store(ObjectType $objectType)
    {
        $data = request()->only(["price", "maintain", "name", "image"]);

        try {
            $object = $objectType->objects()->create($data);
            return $object;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update an object
     *
     * @param ObjectType $objectType
     * @param Object $object
     * @return Object
     * @throws \Exception
     */
    public function update(ObjectType $objectType, \Modules\Inventory\Models\Object $object)
    {
        $data = request()->only(["price", "maintain", "name", "image", "object_type_id"]);

        try {
            $object->update($data);
            return $object;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete an object
     *
     * @param ObjectType $objectType
     * @param Object $object
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ObjectType $objectType, \Modules\Inventory\Models\Object $object)
    {
        try {
            $object->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
