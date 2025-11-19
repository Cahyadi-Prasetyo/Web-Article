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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('categories');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('excerpt');
            $table->enum('status', ['draft', 'pending', 'published', 'rejected', 'archived'])->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
