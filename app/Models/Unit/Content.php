<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded  = ['id'];

    public static function tmp()
    {
        return static::create();
    }

    public function medias()
    {
        $arr = $this->belongsToMany(Media::class);
        foreach ($arr->get()  as $medi) {
            Media::access($medi->id);
        }
        return $arr;
    }

    public function access()
    {
        foreach ($this->medias  as $medi) {
            Media::access($medi->id);
        }
    }

    public function getContentAttribute()
    {
        $this->access();
        return $this->html;
    }
}
