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
        Schema::create('mixes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
          
            
            $table->softDeletes();
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('code');
            $table->unsignedBigInteger('schema_id');


            $table->unique('code', 'schema_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mixes');
    }
};
