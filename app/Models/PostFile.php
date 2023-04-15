<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    protected $fillable = [
        'file_url',
        'file_name',
        'mime_type',
        'size',
    ];
}
