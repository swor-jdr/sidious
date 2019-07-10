<?php

namespace Modules\Forum\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForumTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function it_stores_a_forum()
    {

    }

    public function it_updates_a_forum()
    {

    }

    public function it_throws_exception_if_not_valid()
    {

    }

    public function it_destroys_forum_softly()
    {
        
    }

    public function it_destroys_child_topics_when_deleted()
    {
        
    }

    public function it_destroys_child_forums_when_deleted()
    {
        
    }

    public function non_admin_cannot_use_forum_api()
    {

    }
}