<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Get forum with all topics
     *
     * @param Forum $forum
     * @return Forum
     */
    public function index(Forum $forum)
    {
        $forum->load("topics", "topics.lastPost");
        return $forum;
    }

    /**
     * Store a topic
     *
     * @param Forum $forum
     * @return mixed
     * @throws \Exception
     */
    public function store(Forum $forum)
    {
        $data = request()->only("name");
        $data['forum_id'] = $forum->id;
        $data['author'] = auth()->user()->getAuthIdentifier();

        try {
            $topic = Topic::create($data);
            return $topic;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Store a topic
     *
     * @param Forum $forum
     * @param Topic $topic
     * @return Topic
     */
    public function show(Forum $forum, Topic $topic)
    {
        $topic->load("forum", "posts");
        return $topic;
    }

    public function update(Forum $forum, Topic $topic)
    {

    }

    /**
     * Delete a topic
     *
     * @param Forum $forum
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Forum $forum, Topic $topic)
    {
        try {
            $topic->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
