<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = FactoryHelper::getRandomModelId(User::class);
        $postId = FactoryHelper::getRandomModelId(Post::class);

        return [
            'body' => [],
            'user_id' => $userId,
            'post_id' => $postId,
        ];
    }
}
