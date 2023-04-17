<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TBL_POSTS = 'posts';
    const TBL_USERS = 'users';
    const TBL_COMMENTS = 'comments';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(static::TBL_COMMENTS, function (Blueprint $table) {
            $table->id();
            create_foreign_key($table, static::TBL_USERS, 'cascade');
            create_foreign_key($table, self::TBL_POSTS, 'cascade');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(static::TBL_COMMENTS);
    }
};
