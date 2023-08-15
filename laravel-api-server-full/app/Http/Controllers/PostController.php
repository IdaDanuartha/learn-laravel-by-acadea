<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $pageSize = $request->page_size ?? 12;
        $posts = Post::with(['comments', 'users'])->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): PostResource
    {
        $created = DB::transaction(function() use ($request) {
            $created = Post::create([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            $created->users()->sync($request->user_ids);
            return $created;
        });

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        return new PostResource([[
            'data' => $post
        ]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
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

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): PostResource | JsonResponse
    {
        $deleted = $post->forceDelete();

        if(!$deleted) {
            return new JsonResponse([
                'data' => 'Post failed to delete'
            ], 400);
        }

        return new PostResource($post);
    }
}
