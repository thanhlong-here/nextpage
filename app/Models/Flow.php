<?php

namespace App\Models;

use App\Models\Traits\FlowRoute;
use App\Models\Traits\HasDraft;
use App\Models\Unit\Embed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Flow extends Model
{
    use HasFactory, HasDraft, FlowRoute;
    protected $guarded  = ['id'];
    protected $attributes = ['prefix' => 'web'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];


    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function embed($method)
    {
        return Embed::firstOrCreate([
            'code' => $method,
            'belong' => 'flow',
            'belong_id' => $this->id,
            'type' => 'act'
        ]);
    }

    public function getEmbedsAttribute()
    {
        return Embed::where(['belong' => 'flow', 'belong_id' => $this->id])->get();
    }


    public function test()
    {
        if ($this->embed('test')->source) return $this->embed('test')->run($this);
        return $this->run();
    }

    public function run($method = 'get')
    {
        $x = $this->embed('kernel')->run($this) ?? null;
        return $this->embed($method)->run($x);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'flow_role');
    }

    static function newdraft($prefix = 'web', $app_id = null)
    {
        $wh = ['user_id' => Auth::id(), 'prefix' => $prefix, 'published_at' => null, 'app_id' => $app_id];
        $qid = uniqid();
        return static::firstOrCreate($wh, array_merge($wh, [
            'code' => $qid,
            'uri' => $qid
        ]));
    }


    static function has($code, $prefix = 'web', $app_id = null)
    {
        $wh = ['code' => $code, 'prefix' => $prefix, 'app_id' => $app_id];
        return static::firstOrCreate($wh, array_merge($wh, [
            'published_at' => now(),
            'user_id' => Auth::id(),
            'uri' => $code
        ]));
    }



    static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {

            foreach ($model->embeds as $embed) {
                $embed->delete();
            }
        });
    }
}
