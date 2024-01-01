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
        Schema::create('flows', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('published_at')->nullable(); // thời gian xuất bản
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('app_id')->nullable();
            $table->string('prefix', 12)->nullable()->default('web');
            $table->string('code');
            $table->unique(['code', 'prefix','app_id']);
            $table->string('uri');
            $table->boolean('is_public')->nullable()->default(1);
         
            // $table->unsignedBigInteger('get_embed_id')->nullable();
            // $table->unsignedBigInteger('post_embed_id')->nullable();
            // $table->unsignedBigInteger('put_embed_id')->nullable();
            // $table->unsignedBigInteger('delete_embed_id')->nullable();
          
        });
      
        Schema::create('flow_role', function (Blueprint $table) {
            $table->unsignedBigInteger('flow_id');
            $table->foreign('flow_id')->references('id')->on('flows')->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flows');
        Schema::dropIfExists('flow_role');
    }
};
