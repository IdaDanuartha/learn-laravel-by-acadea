<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = Post::with(['comments', 'users'])->get();

        return new JsonResponse([
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $created = DB::transaction(function() use ($request) {
            $created = Post::create([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            $created->users()->sync($request->user_ids);
            return $created;
        });

        return new JsonResponse([
            'data' => $created
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return new JsonResponse([[
            'data' => $post
        ]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $updated = $post->update($request->only(['title', 'body']));
        // $updated = $post->update([
        //     'title' => $request->title ?? $post->title,
        //     'body' => $request->body ?? $post->body,
        // ]);

        if(!$updated) {
            return new JsonResponse([
                'data' => 'Post failed to update'
            ], 400);
        }

        return new JsonResponse([
            'data' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        $deleted = $post->forceDelete();

        if(!$deleted) {
            return new JsonResponse([
                'data' => 'Post failed to delete'
            ], 400);
        }

        return new JsonResponse([
            'data' => $post
        ]);
    }
}
