<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
// use PHPUnit\Framework\TestCase;
Use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    public function test_create()
    {
        // 1. Define the goal
        // test if create() will actually create a record in the DB

        // 2. Replicate the env / restriction
        $repository = $this->app->make(PostRepository::class);

        //  3. Define the source of truth
        $payload = [
            'title' => "Heyaa",
            "body" => []
        ];

        // 4. Compare the result
        $result = $repository->store($payload);

        $this->assertSame($payload['title'], $result->title, 'Post created does not have the same title');
    }

    public function test_update()
    {
        // Goal : make sure we can update a post using the update method

        // env
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];
        
        $payload = [
            'title' => "abc123",
        ];

        // 4. Compare the result
        $updated = $repository->update($dummyPost, $payload);

        $this->assertSame($payload['title'], $updated->title, 'Post updated does not have the same title');
    }

    public function test_delete_will_throw_exception_when_delete_post_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->make()->first();

        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummy);
    }

    public function test_delete()
    {
        // Goal : test if forceDelete is working

        // env
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->create()->first();

        // compare
        $deleted = $repository->forceDelete($dummy);

        // verify if it is deleted
        $found = Post::query()->find($dummy->id);

        $this->assertSame(null, $found, 'Post is not deleted');
    }
}
