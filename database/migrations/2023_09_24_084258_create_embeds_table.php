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
        Schema::create('embeds', function (Blueprint $table) {
            $table->id();
            $table->string('code',12)->nullable();
            $table->string('belong',12);
            $table->unsignedBigInteger('belong_id');
            $table->unique(['code', 'belong','belong_id']);

            $table->longText('source')->nullable();
            $table->string('type')->default('act');//ui;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeds');
    }
};
