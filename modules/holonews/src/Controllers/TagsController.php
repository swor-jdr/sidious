<?php
namespace Modules\Holonews\Controllers;

use Modules\Holonews\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\Holonews\Resources\TagsResource;

class TagsController
{
    /**
     * Return posts.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = Tag::when(request()->has('search'), function ($q) {
            $q->where('name', 'LIKE', '%'.request('search').'%');
        })
            ->orderBy('created_at', 'DESC')
            ->withCount('posts')
            ->get();

        return TagsResource::collection($entries);
    }

    /**
     * Return a single post.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id = null)
    {
        if ($id === 'new') {
            return response()->json([
                'entry' => Tag::make([
                    'id' => Str::uuid(),
                ]),
            ]);
        }

        $entry = Tag::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store a single category.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $data = [
            'name' => request('name'),
            'slug' => request('slug'),
            'meta' => request('meta', (object) []),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique(config('holonews.database_connection').'.tags', 'slug')->ignore(request('id')),
        ])->validate();

        $entry = $id !== 'new' ? Tag::findOrFail($id) : new Tag(['id' => request('id')]);

        $entry->fill($data);

        $entry->save();

        return response()->json([
            'entry' => $entry->fresh(),
        ]);
    }

    /**
     * Return a single tag.
     *
     * @param  string  $id
     * @return void
     */
    public function delete($id)
    {
        $entry = Tag::findOrFail($id);

        $entry->delete();
    }
}
