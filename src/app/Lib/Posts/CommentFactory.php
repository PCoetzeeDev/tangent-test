<?php

namespace App\Lib\Posts;

use App\Base\BaseFactory;

/**
 * @extends BaseFactory
 */
class CommentFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'post_id' => null,
            'code' => fake()->uuid(),
            'content' => fake()->text(500),
        ];
    }
}
