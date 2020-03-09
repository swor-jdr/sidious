<?php
namespace Modules\Holonews\Controllers;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\Holonews\Models\Article;
use Modules\Holonews\Models\Tag;
use Modules\Holonews\Resources\PostsResource;

class PostsController
{
    /**
     * Return posts.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = Article::when(request()->has('search'), function ($q) {
            $q->where('title', 'LIKE', '%' . request('search') . '%');
        })->when(request('status'), function ($q, $value) {
            $q->$value();
        })->when(request('author_id'), function ($q, $value) {
            $q->whereAuthorId($value);
        })->when(request('tag_id'), function ($q, $value) {
            $q->whereHas('tags', function ($query) use ($value) {
                $query->where('id', $value);
            });
        })
            ->orderBy('created_at', 'DESC')
            ->with('tags')
            ->paginate(30);

        return PostsResource::collection($entries);
    }

    /**
     * Return a single post.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id = null)
    {
        if ($id == '-1' || is_null($id)) {
            return response()->json([
                'entry' => Article::make(['publish_date' => now()->format('Y-m-d H:i:00')]),
            ]);
        }

        $entry = Article::with('tags')->findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store a single post.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $data = [
            'title' => request('title'),
            'excerpt' => request('excerpt', ''),
            'slug' => request('slug'),
            'body' => request('body', ''),
            'published' => request('published'),
            'author_id' => request('author_id'),
            'featured_image' => request('featured_image'),
            'featured_image_caption' => request('featured_image_caption', ''),
            'publish_date' => request('publish_date', ''),
            'meta' => request('meta', (object) []),
        ];

        validator($data, [
            'publish_date' => 'required|date',
            'author_id' => 'required',
            'title' => 'required',
            'slug' => 'required|' . Rule::unique(config('holonews.database_connection') . '.articles', 'slug')->ignore(request('id')),
        ])->validate();

        $entry = $id != '-1' ? Article::findOrFail($id) : new Article();
        $entry->fill($data);
        $entry->save();

        $entry->tags()->sync(
            $this->collectTags(request('tags'))
        );

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Tags incoming from the request.
     *
     * @param  array  $incomingTags
     * @return array
     */
    private function collectTags($incomingTags)
    {
        $allTags = Tag::all();

        return collect($incomingTags)->map(function ($incomingTag) use ($allTags) {
            $tag = $allTags->where('id', $incomingTag['id'])->first();

            if (!$tag) {
                $tag = Tag::create([
                    'name' => $incomingTag['name'],
                    'slug' => Str::slug($incomingTag['name']),
                ]);
            }

            return $tag->id;
        })->toArray();
    }

    /**
     * Return a single post.
     *
     * @param  string  $id
     * @return void
     */
    public function delete($id)
    {
        $entry = Article::findOrFail($id);

        $entry->delete();
    }

    /**
     * Get all posts with tags and author
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        $all = Article::with(['author', 'tags'])
            ->when(request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%' . request('search') . '%');
            })
            ->when(request('author_id'), function ($q, $value) {
                $q->whereAuthorId($value);
            })
            ->when(request('tag_id'), function ($q, $value) {
                $q->whereHas('tags', function ($query) use ($value) {
                    $query->where('id', $value);
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
        return $all;
    }

    /**
     * Get one post with slug
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Article
     */
    public function get(string $slug)
    {
        return Article::with(['author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
