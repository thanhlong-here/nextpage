<?php

namespace App\Models\Traits;

trait HasDraft
{
    public function getDraftAttribute()
    {
        return empty($this->published_at);
    }

    public function scopePublished($query, $where = null)
    {
        $query->whereNotNull('published_at');
        if (isset($where)) $query->where($where);
        return $query;
    }
}
