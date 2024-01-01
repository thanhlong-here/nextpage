<?php

namespace App\Models\Traits;


trait AccessMedia
{

    public function getSrcAttribute()
    {
        $this->open();
        return route('x.medi.open', $this);
    }

    public function open($access = true)
    {
        static::access($this->id, $access);
    }

    public function getIsOpenAttribute()
    {
        return static::hasAccess($this->id);
    }

    public static function access($id, $push = true)
    {
        if (!$push && static::hasAccess($id)) session()->pull('_mediaaccess', $id);
        if ($push && !static::hasAccess($id)) session()->push('_mediaaccess', $id);
    }

    public static function hasAccess($id)
    {
        return in_array($id, session('_mediaaccess', []));
    }
}
