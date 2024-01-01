<?php

namespace App\Models\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait HasTable
{

    function xtable()
    {
        return "_x$this->id";
    }

    function make()
    {
        Schema::create($this->xtable(), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('published_at')->nullable(); // thời gian xuất bản
            $table->string('code')->unique();
            $table->unsignedBigInteger('user_id')->nullable();  
            $table->softDeletes();
        });
    }

    function drop()
    {
        if (Schema::hasTable($this->xtable())) Schema::dropIfExists($this->xtable());
    }

}
