<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];

    public static function findCode($code)
    {
        return static::WhereCode($code)->firstOrFail();
    }

    public function flows()
    {
        return $this->belongsToMany(Flow::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
