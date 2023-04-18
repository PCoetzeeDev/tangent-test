<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function listWithFilter() : CommentCollection
    {
    }

    public function getComment(string $code) : CommentResource
    {
    }

    public function createComment(CreateCommentRequest $request)
    {
    }

    public function editComment(Request $request, string $code)
    {
    }

    public function deleteComment(string $code)
    {
    }
}
