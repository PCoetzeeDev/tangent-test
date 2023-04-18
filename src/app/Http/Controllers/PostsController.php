<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\ListPostsWithFilterRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Lib\Posts\Category;
use App\Lib\Posts\PostFactory;
use App\Lib\Posts\PostRepository;
use App\Lib\Users\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @group Posts
 *
 * Endpoints to interact with posts
 */
class PostsController extends Controller
{
    /**
     * @param ListPostsWithFilterRequest $request
     * @return PostCollection
     */
    public function listWithFilter(ListPostsWithFilterRequest $request) : PostCollection
    {
        return new PostCollection(PostRepository::getWithFilter($request, true));
    }

    /**
     * @param string $code
     * @return PostResource
     */
    public function getPost(string $code) : PostResource
    {
        $post = PostRepository::getByCode($code);

        if (!$post->exists) {
            throw new ResourceNotFoundException(); // Unlikely to trigger as middleware already checks for this
        }

        return new PostResource($post);
    }

    /**
     * @param CreatePostRequest $request
     * @return PostResource
     * @throws \App\Exceptions\InstantiateAttemptInWrongEnvException
     * @throws \App\Exceptions\UnknownEnvironmentException
     */
    public function createPost(CreatePostRequest $request) : PostResource
    {
        $newPost = PostFactory::instantiate([
            'headline' => $request->input('headline'),
            'content' => $request->input('content'),
        ])
            ->setUser(UserRepository::getByCode($request->input('user')))
            ->setCategory(Category::getBySlug($request->input('category')));

        if (PostRepository::persist($newPost)->exists) {
            return new PostResource($newPost);
        }

        throw new InternalErrorException('Failed to create new post');
    }

    /**
     * @param UpdatePostRequest $request
     * @param string $code
     * @return PostResource
     */
    public function editPost(UpdatePostRequest $request, string $code) : PostResource
    {
        $post = PostRepository::getByCode($code);
        $post->fill($request->input());

        PostRepository::persist($post);

        return new PostResource($post);
    }

    /**
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePost(string $code) : JsonResponse
    {
        if (PostRepository::getByCode($code)->delete()) {
            return response()->json(['message' => 'post was successfully deleted'], 201);
        }

        return response()->json(['message' => 'Failed to delete post'], 500);
    }
}
