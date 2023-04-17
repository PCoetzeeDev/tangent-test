<?php

namespace App\Lib\Posts;

use App\Base\BaseEntity;
use App\Base\HasUniqueCodeTrait;
use App\Lib\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends BaseEntity
{
    use HasFactory, HasUniqueCodeTrait;

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'code',
        'headline',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category) : self
    {
        $this->category()->associate($category);

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user) : self
    {
        $this->user()->associate($user);

        return $this;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user ?? new User();
    }

    /**
     * @return Category
     */
    public function getCategory() : Category
    {
        return $this->category ?? new Category();
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
