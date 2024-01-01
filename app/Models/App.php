<?php

namespace App\Models;

use App\Models\Traits\HasDraft;
use App\Models\Unit\Embed;
use App\X\Detect;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class App extends Model
{
    use HasFactory, HasDraft;
    protected $guarded  = ['id'], $menus = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];

    static $ui = [
        'icon' => 'fe fe-airplay',
        'name' => 'app',
    ];



    public function screens()
    {
        return $this->hasMany(Flow::class);
    }

    public function getMainScreenAttribute()
    {
        return $this->screen('main');
    }


    public function screen($code)
    {

        $screen = Flow::has($code, 'app', $this->id);

        Detect::add("Screen::$code", route('x.flow.edit', $screen));

        return $screen;
    }


    static function newdraft()
    {
        $wh = ['user_id' => Auth::id(), 'published_at' => null];

        return static::firstOrcreate($wh, array_merge($wh, [
            'code' => uniqid()
        ]));
    }



    static function has($code)
    {
        return static::first(['code' => $code]);
    }

    public function embed($method)
    {
        return Embed::firstOrCreate([
            'code' => $method,
            'belong' => 'app',
            'belong_id' => $this->id,
            'type' => 'act'
        ]);
    }

    static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            foreach ($model->screens as $screen) {
                $screen->delete();
            }
        });
    }

    // //Route
    // static function route($act, $request = null)
    // {
    //     return route("x.app.$act", $request);
    // }
}
