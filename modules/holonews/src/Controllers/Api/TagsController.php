<?php
namespace Modules\Holonews\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Holonews\Models\Tag;

class TagsController extends Controller
{
    /**
     * Get all tags
     *
     * @return \Illuminate\Database\Eloquent\Collection|Tag[]
     */
    public function index()
    {
        return Tag::all();
    }
}
