<?php

namespace App\Lib\Posts;

use App\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository
{
    /**
     * @param array $filterBy
     * @param bool $paginate
     * @return Collection|LengthAwarePaginator
     */
    public static function getWithFilter(array $filterBy = [], bool $paginate = false) : Collection | LengthAwarePaginator
    {
        $query = Post::query();
        foreach ($filterBy as $filterCol => $filterVal) {
            if ($filterVal === null) {
                continue;
            }
            $query->where($filterCol, '=', $filterVal);
        }
        $query->orderBy('created_at', 'desc');

        return $paginate ? $query->paginate(10) : $query->get();
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
