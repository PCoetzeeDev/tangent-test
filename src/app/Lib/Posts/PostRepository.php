<?php

namespace App\Lib\Posts;

use App\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository
{
    /**
     * @param bool $paginate
     * @return Collection|LengthAwarePaginator
     */
    public static function getAll(bool $paginate = false) : Collection | LengthAwarePaginator
    {
        return $paginate ? Post::paginate() : Post::all();
    }

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
