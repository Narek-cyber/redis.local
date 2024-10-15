<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $posts = Cache::rememberForever('posts:all', function () {
            return Post::all();
        })->each(function ($post) {
            Cache::put('posts:' . $post->id, $post);
        });

        return response()->json([
            'posts' => $posts,
        ]);
    }

    /**
     * @return mixed
     */
    public function getCachedIndex()
    {
        $posts = Cache::get('posts:all');
        return response()->json([
            'posts' => $posts,
        ]);
    }

    /**
     * @param $id
     * @return void
     */
    public function show($id)
    {
        $post = Cache::get("posts:$id");
        return response()->json([
            'post' => $post,
        ]);
    }

    public function store(Request $request)
    {
        $validator = validator(
            $request->only('title', 'content', 'likes'),
            [
                'title' => ['required', 'string'],
                'content' => ['required', 'string'],
                'likes' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post = Post::query()->create($validator->validated());
        Cache::put('posts:' . $post->id, $post);

        return response()->json([
            'post' => $post,
        ]);
    }
}
