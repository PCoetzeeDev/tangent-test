<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Lib\Posts\PostRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostsController extends Controller
{
    /**
     * @param string $code
     * @return PostResource
     */
    public function getPost(string $code) : PostResource
    {
        $post = PostRepository::getByCode($code);

        if (!$post->exists) {
            throw new NotFoundHttpException();
        }

        return new PostResource($post);
    }

    public function createPost(Request $request)
    {

    }

    public function editPost(Request $request)
    {

    }

    public function deletePost(Request $request)
    {

    }
}
