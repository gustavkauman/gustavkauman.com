<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function regular_visitor_can_access_index_page()
    {
        $response = $this->get(route('post.index'));

        $response->assertStatus(200);
    }

}
