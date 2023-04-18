<?php

namespace App\Lib\Posts;

use App\Base\BaseRepository;
use App\Http\Requests\ListCommentsWithFilterRequest;
use App\Lib\Users\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository extends BaseRepository
{
    /**
     * @param ListCommentsWithFilterRequest $request
     * @param bool $paginate
     * @return Collection|LengthAwarePaginator
     */
    public static function getWithFilter(ListCommentsWithFilterRequest $request, bool $paginate = false) : Collection | LengthAwarePaginator
    {
        $inputFilter = $request->input('filter');
        $inputSort = $request->input('sort');
        $inputInclude = $request->input('include');

        $request->replace(['filter' => [
            'user' => !empty($inputFilter['user']) ? UserRepository::getByCode($inputFilter['user'])->id : null,
            'post' => !empty($inputFilter['post']) ? PostRepository::getByCode($inputInclude['post'])->id : null,
        ]]);

        $comments = QueryBuilder::for(Comment::class, $request)
            ->allowedFilters([
                AllowedFilter::exact('user', 'user_id'),
                AllowedFilter::exact('post', 'post_id'),
            ])
            ->allowedSorts(['created_at', 'updated_at'])
            ->allowedIncludes(['user', 'post']);

        return $paginate ? $comments->paginate(10)->appends([
            'filter' => $inputFilter,
            'sort' => $inputSort,
            'include' => $inputInclude
        ]) : $comments->get();
    }

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

    /**
     * @return Collection
     */
    public static function getAll() : Collection
    {
        return Comment::all();
    }
}
