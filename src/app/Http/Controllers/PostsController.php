<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Lib\Posts\Category;
use App\Lib\Posts\PostFactory;
use App\Lib\Posts\PostRepository;
use App\Lib\Users\UserRepository;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * @return PostCollection
     */
    public function listAllPosts() : PostCollection
    {
        return new PostCollection(PostRepository::getAll(true));
    }

    /**
     * @param string $code
     * @return PostResource
     */
    public function getPost(string $code) : PostResource
    {
        $post = PostRepository::getByCode($code);

//        if (!$post->exists) {
//            throw new NotFoundHttpException('');
//        }

        return new PostResource($post);
    }

    /**
     * @param CreatePostRequest $request
     * @return PostResource
     * @throws \App\Exceptions\InstantiateAttemptInWrongEnvException
     * @throws \App\Exceptions\UnknownEnvironmentException
     */
    public function createPost(CreatePostRequest $request)
    {
        $newPost = PostFactory::instantiate([
            'headline' => $request->input('headline'),
            'content' => $request->input('content'),
        ])
            ->setUser(UserRepository::getByCode($request->input('user')))
            ->setCategory(Category::getBySlug($request->input('category')))
            ->save();

        return new PostResource($newPost);
    }

    public function editPost(Request $request, string $code)
    {
        dd(__METHOD__);
    }

    public function deletePost(Request $request)
    {

    }
}
