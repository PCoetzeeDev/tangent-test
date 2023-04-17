<?php

namespace App\Lib\Posts;

use App\Base\BaseRepository;

class CommentRepository extends BaseRepository
{
    /**
     * @param string $code
     * @return Comment
     */
    public static function getByCode(string $code) : Comment
    {
        return Comment::query()
            ->where('code', '=', $code)
            ->limit(1)
            ->get()
            ->first() ?? new Comment();
    }
}
