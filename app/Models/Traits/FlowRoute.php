<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

trait FlowRoute
{

    function access()
    {
        if ($this->is_public) return true;
        $user = auth()->user();

        if (empty($user)) return false;
        if ($user->is_root) return true;
        foreach ($this->roles as $role) {
            if ($user->roles->contains('id', $role->id)) return true;
        }
        return false;
    }

    public function getRouteNameAttribute()
    {

        return $this->app_id ? "$this->prefix.$this->app->code.$this->code" :  "$this->prefix.$this->code";
    }

    function route($method)
    {
        $flow = $this;
        $uri = $this->app_id ? "$this->app_id/$this->uri" :  $this->uri;

        Route::$method($uri, function () use ($method, $flow) {
            if (!$flow->access()) return abort(401);
            return $flow->run($method);
        });
    }


    public static function routes($prefix = 'web')
    {

        if (Schema::hasTable('flows')) {
            foreach (static::wherePrefix($prefix)->get() as $flow) {
                Route::name($flow->route_name)->group(function () use ($flow) {
                    foreach (['get', 'post'] as $method) {
                        $flow->route($method);
                    }
                });
            };
        }
    }
}
