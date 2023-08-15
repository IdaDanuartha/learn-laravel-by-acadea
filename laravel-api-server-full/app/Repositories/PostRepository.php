<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function store(array $attributes) 
    {
        return DB::transaction(function() use ($attributes) {
            $created = Post::create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
            ]);

            if($userIds = data_get($attributes, 'user_ids')) {
                $created->users()->sync($userIds    );
            }
            return $created;
        });
    }
    
    /**
     * @param Post $post
     * @param array $attributes
     * @return mixed
     */
    public function update($post, array $attributes) 
    {
        return DB::transaction(function() use ($post, $attributes) {
            $updated = $post([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body),
            ]);
    
            if(!$updated) {
                throw new \Exception('Failed to update post');
            }

            if($userIds = data_get($attributes, 'user_ids')) {
                $updated->users()->sync($userIds);
            }

            return $post;
        });
        
    }

        /**
     * @param Post $post
     * @return mixed
     */
    public function forceDelete($post) {
        return DB::transaction(function() use ($post) {
            $deleted = $post->forceDelete();

            if(!$deleted) {
                throw new \Exception('Cannot delete post');
            }

            return $deleted;
        });
    }
}
