<?php

namespace App\Lib\Posts;

use App\Base\ValueObjects\ValueObject;

class Category extends ValueObject
{
    const WEB_DEVELOPMENT = 'web_development';
    const EMBEDDED_ENGINEERING = 'embedded_engineering';
    const DEVOPS = 'devops';
    const SECOPS = 'secops';
    const PEOPLEWARE = 'peopleware';
    const OS_DISCUSSIONS = 'os_discussions';
    const GENERAL = 'general';
    const RANT = 'rant';

    const CURRENT_CATEGORIES = [
        self::WEB_DEVELOPMENT,
        self::EMBEDDED_ENGINEERING,
        self::DEVOPS,
        self::SECOPS,
        self::PEOPLEWARE,
        self::OS_DISCUSSIONS,
        self::GENERAL,
        self::RANT,
    ];

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'order',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

}
