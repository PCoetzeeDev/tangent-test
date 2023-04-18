<?php

namespace App\Lib\Posts;

use App\Base\BaseFactory;

/**
 * @extends BaseFactory
 */
class PostFactory extends BaseFactory
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
            'category_id' => Category::getBySlug(fake()->randomElement(Category::CURRENT_CATEGORIES))->getId(),
            'code' => fake()->uuid(),
            'headline' => fake()->text(100),
            'content' => fake()->text(500),
        ];
    }
}
