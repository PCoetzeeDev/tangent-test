<?php

namespace App\Lib\Posts;

use App\Base\BaseRepository;
use App\Http\Requests\ListPostsWithFilterRequest;
use App\Lib\Users\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostRepository extends BaseRepository
{
    /**
     * @param ListPostsWithFilterRequest $request
     * @param bool $paginate
     * @return Collection|LengthAwarePaginator
     */
    public static function getWithFilter(ListPostsWithFilterRequest $request, bool $paginate = false) : Collection | LengthAwarePaginator
    {
        $inputFilter = $request->input('filter');
        $inputSort = $request->input('sort');
        $inputInclude = $request->input('include');

        $request->replace(['filter' => [
            'user' => !empty($inputFilter['user']) ? UserRepository::getByCode($inputFilter['user'])->id : null,
            'category' => !empty($inputFilter['category']) ? Category::getBySlug($inputFilter['category'])->getId() : null,
        ]]);

        $posts = QueryBuilder::for(Post::class, $request)
            ->allowedFilters([
                AllowedFilter::exact('user', 'user_id'),
                AllowedFilter::exact('category', 'category_id'),
            ])
            ->allowedSorts(['created_at', 'updated_at'])
            ->allowedIncludes(['user', 'category']);

        return $paginate ? $posts->paginate(10)->appends([
            'filter' => $inputFilter,
            'sort' => $inputSort,
            'include' => $inputInclude
        ]) : $posts->get();
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

    /**
     * @return Collection
     */
    public static function getAll() : Collection
    {
        return Post::all();
    }
}
