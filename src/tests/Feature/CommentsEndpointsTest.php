<?php

namespace Tests\Feature;

use App\Lib\Posts\CommentRepository;
use App\Lib\Posts\PostRepository;
use App\Lib\Users\UserRepository;
use Tests\TestCase;

class CommentsEndpointsTest extends TestCase
{

    const PATH = '/api/v1/comments/';

    /**
     * @return void
     */
    public function test_comment_list(): void
    {
        $response = $this->get(self::PATH);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_create_comment(): void
    {
        $response = $this->post(self::PATH, [
            'user' => UserRepository::getAll()->random(1)->first()->code,
            'post' => PostRepository::getAll()->random(1)->first()->code,
            'content' => 'Marco Polo said ping pong',
        ]);

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function test_get_comment(): void
    {
        $comment = CommentRepository::getAll()->random(1)->first();

        $this->assertModelExists($comment);

        $response = $this->get(self::PATH . $comment->code);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_edit_comment(): void
    {
        $comment = CommentRepository::getAll()->random(1)->first();

        $response = $this->patch(self::PATH . $comment->code, [
            'content' => 'CHANGED!',
        ]);

        $response->assertStatus(200);

        $comment = CommentRepository::getByCode($comment->code);
        $this->assertEquals('CHANGED!', $comment->content);
    }

    /**
     * @return void
     */
    public function test_delete_comment(): void
    {
        $comment = CommentRepository::getAll()->random(1)->first();

        $response = $this->delete(self::PATH . $comment->code);

        $response->assertStatus(201);

        $comment = CommentRepository::getByCode($comment->code);
        $this->assertModelMissing($comment);
    }
}
