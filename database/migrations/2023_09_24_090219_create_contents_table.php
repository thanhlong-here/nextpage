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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->longText('html')->nullable();
            // $table->string('belong',12);
            // $table->unsignedBigInteger('belong_id');
        });

        Schema::create('content_media', function (Blueprint $table) {
            $table->unsignedBigInteger('content_id');
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            
            $table->unsignedBigInteger('media_id');
            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
        Schema::dropIfExists('content_media');
    }
};
