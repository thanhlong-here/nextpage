<?php

namespace App\Models\Unit;

use App\Models\Traits\EmbedCompiler;
use App\Models\Traits\EmbedReference;
use App\X\Comp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Embed extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded  = ['id'];
    protected $storage = 'app/embed/';

    protected $attributes = ['type' => 'act'];

   
    public function getObjBelongAttribute()
    {
        $class = "App\\Models\\$this->belong";
        return $class::find($this->belong_id);
    }
    

    function comp(){
        return new Comp($this);
    }

    public function run($x = []){
        return $this->comp()->run($x);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($emb) {
            $emb->comp()->delete();
        });

        static::updated(function ($emb) {
            $emb->comp()->save();
        });
    }
}
