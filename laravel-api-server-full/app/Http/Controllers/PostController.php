<?php

namespace App\Http\Controllers;

use App\Events\Model\User\UserCreated;
use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Notifications\PostSharedNotification;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;
use Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        // throw new GeneralJsonException("Errorrsss");
        $pageSize = $request->page_size ?? 12;
        $posts = Post::with(['comments', 'users'])->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, PostRepository $repository): PostResource
    {        
        $created = $repository->store($request->only([
            'title',
            'body',
            'user_ids'
        ]));

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
    public function update(UpdatePostRequest $request, Post $post, PostRepository $repository)
    {
        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids'
        ]));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostRepository $repository): PostResource | JsonResponse
    {
        $post = $repository->forceDelete($post);

        return new PostResource($post);
    }

    /**
     * Share a specified resource from storage.
     */
    public function share(Request $request, Post $post): JsonResponse
    {
        $url = URL::temporarySignedRoute('posts.share', now()->addSeconds(30), [
            'post' => $post->id
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();

        Notification::send($users, new PostSharedNotification($post, $url));

        $user = User::find(1);
        $user->notify(new PostSharedNotification($post, $url));

        return new JsonResponse([
            'data' => $url
        ]);
    }
}
