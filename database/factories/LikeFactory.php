<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::pluck('id')->toArray();
        $post = Post::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($user),
            'post_id' => $this->faker->randomElement($post),
            'is_status' => 1
        ];
    }
}
