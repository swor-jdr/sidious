<?php
namespace Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Modules\Inventory\Models\Improvement;
use Modules\Inventory\Models\ObjectType;

class ImprovementController extends Controller
{
    public function index(ObjectType $objectType)
    {
        return $objectType->improvements()->get();
    }

    public function show(ObjectType $objectType, Improvement $improvement)
    {
        $improvement->type = $objectType;
        return $improvement;
    }

    /**
     * Create improvement
     *
     * @param ObjectType $objectType
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function store(ObjectType $objectType)
    {
        $data = request()->only(["name"]);

        try {
            $improvement = $objectType->improvements()->create($data);
            return $improvement;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param ObjectType $objectType
     * @param Improvement $improvement
     * @return \Illuminate\Database\Eloquent\Model|Improvement
     * @throws \Exception
     */
    public function update(ObjectType $objectType, Improvement $improvement)
    {
        $data = request()->only(["name", "object_type_id"]);

        try {
            $improvement->update($data);
            return $improvement;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete improvement
     *
     * @param ObjectType $objectType
     * @param Improvement $improvement
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ObjectType $objectType, Improvement $improvement)
    {
        try {
            $improvement->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
