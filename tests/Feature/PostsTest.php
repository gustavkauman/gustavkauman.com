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

	/** @test */
	public function an_unknown_user_can_get_a_blog_post_via_json()
	{
		$this->withoutExceptionHandling();
		$post = factory(Post::class)->create(['author_id' => factory(User::class)->create()->id]);

		$response = $this->getJson(route('post.get', ['post' => $post]));
		$response->assertSuccessful();
	}

	/** @test */
	public function the_author_of_post_can_delete_it()
	{
		$post = factory(Post::class)->create(['author_id' => ($author = factory(User::class)->create())->id]);

		$response = $this->actingAs($author)->deleteJson(route('post.destroy', ['post' => $post]));
		$response->assertSuccessful();
		$this->assertDatabaseMissing('posts', $post->getAttributes());
	}

	/** @test */
	public function a_user_cant_delete_another_users_post()
	{
		$author = factory(User::class)->create();
		$user = factory(User::class)->create();
		$post = factory(Post::class)->create(['author_id' => $author->id]);

		$response = $this->actingAs($user)->deleteJson(route('post.destroy', ['post' => $post]));
		$response->assertStatus(403); // assert that the action is unauthorized
		$this->assertDatabaseHas('posts', $post->getAttributes());
	}
}
