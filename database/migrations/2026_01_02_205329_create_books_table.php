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
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('author_id'); // todo foreign key
            $table->integer('publised_year')->nullable();
            $table->string('isbn')->nullable();
            $table->string('image')->nullable();
            $table->integer('pages')->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_wishlist')->default(false);
            $table->text('description')->nullable();
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
