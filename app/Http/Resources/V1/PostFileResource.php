<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

/** @mixin \App\Models\PostFile */
class PostFileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_url' => Storage::url($this->file_url),
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size
        ];
    }
}
