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
}
