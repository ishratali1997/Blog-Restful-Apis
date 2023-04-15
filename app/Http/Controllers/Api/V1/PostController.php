<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\DeletePostFileRequest;
use App\Http\Requests\Api\V1\PostRequest;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;
use App\Models\PostFile;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->with(['files', 'user'])->when($request->query('user_id'), function ($query) use ($request) {
            $query->where('user_id', $request->query('user_id'));
        })->latest()->paginate($this->perPage);

        return $this->successWithData(PostResource::collection($posts));
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        if ($request->hasFile('files')) {
            $post->files()->createMany($this->uploadFiles($request->file('files')));
        }

        return $this->successWithData(PostResource::make($post->load(['user', 'files'])));
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        if ($request->hasFile('files')) {
            $post->files()->createMany($this->uploadFiles($request->file('files')));
        }

        return $this->successWithData(PostResource::make($post->load(['user', 'files'])));
    }

    public function uploadFiles($files): array
    {
        $filesData = [];

        foreach ($files as $file) {
            $data['file_url'] = $file->store('uploads/posts-files');
            $data['file_name'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getClientMimeType();
            $data['size'] = $file->getSize();
            $filesData[] = $data;
        }

        return $filesData;
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        Storage::delete($post->files()->pluck('file_url')->toArray());

        $post->delete();

        return $this->success('Deleted Successfully.');
    }

    public function deleteFiles(DeletePostFileRequest $request)
    {
        try {
            DB::beginTransaction();

            $postFilesQuery = PostFile::query()->whereIn('id', $request->filesIds);

            Storage::delete($postFilesQuery->pluck('file_url')->toArray());

            $postFilesQuery->delete();

            DB::commit();

            return $this->success('Deleted Successfully.');

        } catch (\Exception $exception) {
            return $this->error('Something went wrong, please try again');
        }


    }
}
