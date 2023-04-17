<?php

namespace App\Lib\Users;

class UserRepository
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
}
