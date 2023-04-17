<?php

namespace App\Lib\Posts;

class PostRepository
{
    /**
     * @param string $code
     * @return Post
     */
    public static function getByCode(string $code) : Post
    {
        return Post::query()
            ->where('code', '=', $code)
            ->limit(1)
            ->get()
            ->first() ?? new Post();
    }
}
