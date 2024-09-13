<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title');
			$table->string('author');
			$table->bigInteger('author_id')->unsigned();
			$table->text('desc');
			$table->text('content');
			$table->string('image_url');
			$table->unsignedInteger('comment_count');
			$table->string('access');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
