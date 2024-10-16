<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RedisPostController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $posts = Redis::lrange('posts', 0, -1);

        return response()->json([
            'posts' => $posts,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $post = Post::make((array)json_decode(Redis::get("posts:$id")));

        if (!$post) {
            $post = Post::query()->findOrFail($id);
            Redis::set("posts:$id", json_encode($post));
        }

        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
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

        Redis::set("posts:$post->id", $post);

        return response()->json([
            'post' => $post,
        ]);
    }
}
