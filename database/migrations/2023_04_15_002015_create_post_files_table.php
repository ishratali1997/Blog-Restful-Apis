<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class)->constrained()->cascadeOnDelete();
            $table->string('file_url');
            $table->string('file_name');
            $table->string('mime_type');
            $table->float('size');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_files');
    }
};
