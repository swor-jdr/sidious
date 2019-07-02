<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Post;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Kalnoy\Nestedset\Collection;

class ForumController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        return Forum::where("parent_id", null)->with("children", "children.last", "children.last.topic")
            ->get();
    }

    public function show(Forum $forum)
    {
        $forum->load("children", "children.last", "children.last.topic");
        return $forum;
    }

    /**
     * Store a forum
     *
     * @return mixed
     * @throws \Exception
     */
    public function store()
    {
        try {
            $data = request()->only(['name', "content"]);

            $parent = (request()->only("parent_id")) ? request()->only("parent_id")['parent_id'] : null;
            $parent = Forum::find($parent);

            $forum = Forum::create($data);

            if($parent) {
                $forum->parent_id = $parent->id;
                $forum->save();
            }

            return $forum;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a forum
     *
     * @param Forum $forum
     * @return Forum
     * @throws \Exception
     */
    public function update(Forum $forum)
    {
        $data = request()->only(['name', "content"]);

        $parent = (request()->only("parent_id")) ? request()->only("parent_id")['parent_id'] : null;
        if($parent) $newParent = Forum::findOrFail($parent);

        // Check if forum has to move
        $hasMoved = ($newParent && ($newParent->id !== $forum->parent_id));

        try {
            // Check new ancestors last post with ours
            if($hasMoved && $forum->last_post) {
                // Build new breadcrumbs for given
                $newAncestors = $newParent->getAncestors();
                $newAncestors->prepend($newParent);

                $this->setAncestorsLastPost($newAncestors, $forum->lastPost);
            }

            $forum->update($data);

            // Check ancestors last post then
            if($hasMoved && $forum->last_post) {
                $ancestors = $forum->getAncestors();
                $this->setAncestorsLastPost($ancestors, $forum->lastPost);
            }

            return $forum;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function destroy(Forum $forum)
    {

    }

    private function setAncestorsEvaluateLastPost(Collection $ancestors, Post $lastPost)
    {

    }
}
