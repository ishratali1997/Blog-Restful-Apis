<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Post */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => $this->created_date,
            'user' => UserResource::make($this->whenLoaded('user')),
            'files' => PostFileResource::collection($this->whenLoaded('files'))
        ];
    }
}
