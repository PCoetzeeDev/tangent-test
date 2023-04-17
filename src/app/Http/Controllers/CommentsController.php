<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostCollection;
use App\Lib\Posts\PostRepository;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function listWithFilter() : PostCollection
    {
    }

    public function getComment(string $code) : CommentResource
    {
    }

    public function createComment(CreatePostRequest $request)
    {
    }

    public function editComment(Request $request, string $code)
    {
    }

    public function deleteComment(string $code)
    {
    }
}
