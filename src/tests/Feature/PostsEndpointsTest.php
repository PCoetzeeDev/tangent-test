<?php

namespace Tests\Feature;

use App\Lib\Posts\PostRepository;
use Tests\TestCase;

class PostsEndpointsTest extends TestCase
{

    const PATH = '/api/v1/posts/';

    /**
     * @return void
     */
    public function test_post_list(): void
    {
        $response = $this->get(self::PATH);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_get_post(): void
    {
        $post = PostRepository::getAll()->random(1)->first();

        $this->assertModelExists($post);

        $response = $this->get(self::PATH . $post->code);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_edit_post(): void
    {
        $post = PostRepository::getAll()->random(1)->first();

        $response = $this->patch(self::PATH . $post->code, [
            'headline' => 'CHANGED!',
        ]);

        $response->assertStatus(200);

        $post = PostRepository::getByCode($post->code);
        $this->assertEquals('CHANGED!', $post->headline);
    }

    /**
     * @return void
     */
    public function test_delete_post(): void
    {
        $post = PostRepository::getAll()->random(1)->first();

        $response = $this->delete(self::PATH . $post->code);

        $response->assertStatus(201);

        $post = PostRepository::getByCode($post->code);
        $this->assertModelMissing($post);
    }
}
