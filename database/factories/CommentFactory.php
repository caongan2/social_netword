<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

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
            'content' => $this->faker->text(),
            'user_id' => $this->faker->randomElement($user),
            'post_id' => $this->faker->randomElement($post),
        ];
    }
}
