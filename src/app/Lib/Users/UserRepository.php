<?php

namespace App\Lib\Users;

use App\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    /**
     * @param string $code
     * @return User
     */
    public static function getByCode(string $code) : User
    {
        return User::query()
            ->where('code', '=', $code)
            ->limit(1)
            ->get()
            ->first() ?? new User();
    }

    /**
     * @return Collection
     */
    public static function getAll() : Collection
    {
        return User::all();
    }
}
