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
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->unsignedBigInteger('author_id');
            $table->integer('published_year')->nullable();
            $table->string('isbn')->nullable();
            $table->string('image')->nullable();
            $table->integer('pages')->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_wishlist')->default(false);
            $table->text('description')->nullable();

            $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
