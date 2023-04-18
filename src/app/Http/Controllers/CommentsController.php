<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\ListCommentsWithFilterRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Lib\Posts\CommentFactory;
use App\Lib\Posts\CommentRepository;
use App\Lib\Posts\PostRepository;
use App\Lib\Users\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @group Comments
 *
 * Endpoints to interact with comments
 */
class CommentsController extends Controller
{
    /**
     * @param ListCommentsWithFilterRequest $request
     * @param bool $paginate
     * @return CommentCollection
     */
    public function listWithFilter(ListCommentsWithFilterRequest $request, bool $paginate = false) : CommentCollection
    {
        return new CommentCollection(CommentRepository::getWithFilter($request, $paginate));
    }

    /**
     * @param string $code
     * @return CommentResource
     */
    public function getComment(string $code) : CommentResource
    {
        $comment = CommentRepository::getByCode($code);

        if (!$comment->exists) {
            throw new ResourceNotFoundException(); // Unlikely to trigger as middleware already checks for this
        }

        return new CommentResource($comment);
    }

    /**
     * @param CreateCommentRequest $request
     * @return CommentResource
     * @throws InternalErrorException
     * @throws \App\Exceptions\InstantiateAttemptInWrongEnvException
     * @throws \App\Exceptions\UnknownEnvironmentException
     */
    public function createComment(CreateCommentRequest $request) : CommentResource
    {
        $newComment = CommentFactory::instantiate([
            'content' => $request->input('content'),
        ])
            ->setUser(UserRepository::getByCode($request->input('user')))
            ->setPost(PostRepository::getByCode($request->input('post')));

        if (CommentRepository::persist($newComment)->exists) {
            return new CommentResource($newComment);
        }

        throw new InternalErrorException('Failed to create new comment');
    }

    /**
     * @param UpdateCommentRequest $request
     * @param string $code
     * @return CommentResource
     */
    public function editComment(UpdateCommentRequest $request, string $code) : CommentResource
    {
        $comment = CommentRepository::getByCode($code);
        $comment->fill($request->input());

        CommentRepository::persist($comment);

        return new CommentResource($comment);
    }

    /**
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment(string $code) : JsonResponse
    {
        if (CommentRepository::getByCode($code)->delete()) {
            return response()->json(['message' => 'comment was successfully deleted'], 201);
        }

        return response()->json(['message' => 'Failed to delete comment'], 500);
    }
}
