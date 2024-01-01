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
        Schema::create('schema_fields', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('schema_id');
            $table->unsignedBigInteger('order')->default(0);
            $table->string('code');
            $table->string('type');
            $table->unique(['schema_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schema_fields');
    }
};
