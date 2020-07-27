<?php

namespace Tests\Feature;

use App\Post;
use App\User;
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

    /** @test */
    public function logged_in_authorized_user_can_create_blog_post()
    {
        $user = factory(User::class)->create();
        $user->groups()->attach(\App\UserGroup::where('name', 'authors')->first());

        $post = factory(Post::class)->make();

        $response = $this->actingAs($user)
                        ->putJson(route('post.put'), $post->getAttributes());

        $response->assertSuccessful();
        $this->assertDatabaseHas('posts', $post->getAttributes());
    }

    /** @test */
    public function a_user_can_provide_their_own_slug()
    {
        $user = factory(User::class)->create();
        $user->groups()->attach(\App\UserGroup::where('name', 'authors')->first());

        $post = factory(Post::class)->make();
        $post->slug = $this->faker->slug;

        $response = $this->actingAs($user)
            ->putJson(route('post.put'), $post->getAttributes());

        $response->assertSuccessful();
        $this->assertDatabaseHas('posts', $post->getAttributes());
    }


}
