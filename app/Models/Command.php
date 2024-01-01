<?php

namespace App\Models;

use App\Models\Unit\Embed;
use App\Models\Traits\HasDraft;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Command extends Model
{
    use HasFactory, HasDraft;
    protected $guarded  = ['id'];
    protected $attributes = ['prefix' => 'act'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];

    static function newdraft($prefix = 'act')
    {
        $wh = ['user_id' =>  Auth::id(), 'prefix' => $prefix, 'published_at' => null];
        return static::firstOrCreate($wh, array_merge($wh, ['code' => uniqid()]));
    }


    public function embed($method)
    {
        return Embed::firstOrCreate([
            'code' => $method,
            'belong' => 'command',
            'belong_id' => $this->id,
            'type' => $this->prefix,
        ]);
    }


    public function test()
    {

        if ($this->embed('test')->source) return $this->embed('test')->run($this);
        return $this->run();
    }

    public function run($x = null)
    {
        return $this->embed('source')->run($x);
    }


    static function has($code, $prefix = 'act')
    {
        $wh = ['code' => $code, 'prefix' => $prefix];
        return static::firstOrCreate($wh, array_merge($wh, [
            'published_at' => now(),
            'user_id' => Auth::id()
        ]));
    }

    static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->embed->delete;
        });
    }
}
