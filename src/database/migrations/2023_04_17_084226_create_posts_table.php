<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TBL_POSTS = 'posts';
    const TBL_CATEGORIES = 'categories';
    const TBL_USERS = 'users';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Note: This could also be an intersection table between categories and posts, which would allow multiple categories per post. Effectively tags then
        create_valueobject_schema(static::TBL_CATEGORIES);
        populate_vo_data([
            'Web Development',
            'Embedded Engineering',
            'DevOps',
            'SecOps',
            'PeopleWare',
            'OS Discussions',
            'General',
            'Rant',
        ], static::TBL_CATEGORIES);

        Schema::create(static::TBL_POSTS, function (Blueprint $table) {
            $table->id();
            create_foreign_key($table, self::TBL_USERS, 'cascade');
            create_foreign_key($table, self::TBL_CATEGORIES, 'cascade', 'category_id');
            $table->text('headline');
            $table->text('content');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(static::TBL_POSTS);
        Schema::dropIfExists(static::TBL_CATEGORIES);
    }
};
