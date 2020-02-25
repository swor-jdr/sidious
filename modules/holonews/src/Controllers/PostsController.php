<?php
namespace Modules\Holonews\Controllers;

use Modules\Holonews\Models\Article;

class PostsController
{
    /**
     * Get all posts with tags and author
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        $all = Article::with(['author', 'tags'])
            ->when(request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%'.request('search').'%');
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
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|WinkPost
     */
    public function show(string $slug)
    {
        return Article::with(['author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function clap(Article $article)
    {
        $react = $article->viaLoveReactant()->isReactedBy(auth()->user(), $article);
    }
}
