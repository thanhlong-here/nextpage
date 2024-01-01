<?php

namespace App\Models\Traits;

use App\Models\Schema as mSchema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait HasCol
{

    
    public function getColTypeAttribute()
    {
        return mSchema::$field_types[$this->type];
    }

    function has()
    {
        return Schema::hasColumn($this->xn(), $this->code);
    }

    function make()
    {
        $type = $this->col_type;
        $code = $this->code;

        Schema::table($this->xn(), function (Blueprint $table) use ($type, $code) {
            $table->$type($code)->nullable();
        });
    }

    function remove()
    {
        if (!$this->has()) return;
        $code = $this->code;
        Schema::table($this->xn(), function (Blueprint $table) use ($code) {
            $table->dropColumn($code);
        });
    }

    function change()
    {
        if (!$this->has()) return;
        $that = $this;
        Schema::table($this->xn(), function (Blueprint $table) use ($that) {
            if ($that->isDirty('code')) {
                $table->renameColumn($that->getOriginal('code'), $that->code);
            }
            if ($this->isDirty('type')) {
                $type = $this->col_type;
                $table->$type($this->code)->change();
            }
        });
    }
}
