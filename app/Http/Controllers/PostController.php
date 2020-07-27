<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Show all blog posts in the database.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = Post::all();

        return view('post.index', compact('posts'));
    }

    /**
     * Store the provided blog post in the database.
     *
     * @param Request $request
     * @return
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $data = $this->validateRequest();
        $data['author_id'] = \Auth::id();
        (isset($data['slug']) ?: $data['slug'] = Str::slug($data['title']));

        $post = Post::create($data);

        if ($request->wantsJson()) {
            return $post;
        }

        return redirect()->to($post->path())->withSucces('Blog post successfully created');
    }

    /**
     * Validate the request that's been made to the server.
     *
     * @return array
     */
    private function validateRequest()
    {
        return request()->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'slug' => 'sometimes|string|min:3|max:255|unique:posts,slug'
        ]);
    }


}
