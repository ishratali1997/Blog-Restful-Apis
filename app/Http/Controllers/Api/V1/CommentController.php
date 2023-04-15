<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CommentRequest;
use App\Http\Resources\V1\CommentResource;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->paginate($this->perPage);

        return $this->successWithData(CommentResource::collection($comments));
    }

    public function store(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $comment = $post->comments()->create($data);

        return $this->successWithData(CommentResource::make($comment));
    }

    public function show(Post $post, Comment $comment)
    {
        return $this->successWithData(CommentResource::make($comment));
    }

    public function update(CommentRequest $request, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return $this->successWithData(CommentResource::make($comment));
    }

    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return $this->success("Deleted Successfully.");
    }
}
