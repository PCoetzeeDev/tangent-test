<?php

namespace App\Lib\Posts;

use App\Base\BaseEntity;
use App\Lib\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends BaseEntity
{
    use HasFactory;

    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'user_id',
        'post_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

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
     * @param Post $post
     * @return $this
     */
    public function setPost(Post $post) : self
    {
        $this->post()->associate($post);

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost() : Post
    {
        return $this->post ?? new Post();
    }

    /**
     * @return BelongsTo
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
