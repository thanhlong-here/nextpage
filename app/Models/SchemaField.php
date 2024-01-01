<?php

namespace App\Models;

use App\Models\Traits\HasCol;
use App\Models\Traits\HasSchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemaField extends Model
{
    use HasFactory, HasCol;
    protected $guarded  = ['id'];
    function xn()
    {
        return $this->schema->xtable();
    }

    public function schema()
    {
        return $this->belongsTo(Schema::class, 'schema_id');
    }


    static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->make();
        });

        static::deleted(function ($model) {
            $model->remove();
        });

        static::updating(function ($model) {
            $model->change();
        });
    }
}
