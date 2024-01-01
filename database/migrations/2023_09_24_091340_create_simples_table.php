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
        Schema::create('simples', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('published_at')->nullable(); // thời gian xuất bản
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('code');
            $table->string('type')->default('string');
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simples');
    }
};
