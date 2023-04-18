<?php

namespace Database\Seeders;

use App\Lib\Posts\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Lib\Posts\CommentFactory;
use App\Lib\Posts\PostFactory;
use App\Lib\Posts\PostRepository;
use App\Lib\Users\UserFactory;
use App\Lib\Users\UserRepository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $user = UserFactory::instantiate([], true)->save();

            $randomPostsCount = rand(1, 10);
            for ($count = 0; $count < $randomPostsCount; $count++) {
                $randomCategory = Category::all()->random(1)->first();
                PostFactory::instantiate([], true)
                    ->setUser($user)
                    ->setCategory($randomCategory)
                    ->save();
            }
        }

        foreach (PostRepository::getAll() as $post) {
            $randomCommentsCount = rand(1, 5);
            for ($i = 0; $i < $randomCommentsCount; $i++) {
                $randomUser = UserRepository::getAll()->random(1)->first();
                CommentFactory::instantiate([], true)
                    ->setUser($randomUser)
                    ->setPost($post)
                    ->save();
            }
        }
    }
}
