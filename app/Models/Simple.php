<?php

namespace App\Models;

use App\Models\Traits\FetchData;
use App\Models\Traits\HasDraft;
use App\Models\Unit\Content;
use App\Models\Unit\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Simple extends Model
{
    use HasFactory, HasDraft;
    protected $guarded  = ['id'];
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function getValAttribute()
    {
        if ($this->type == 'media') return Media::find($this->value);
        if ($this->type == 'content') return  Content::find($this->value);

        return $this->value;
    }

    static function ddata($type,$data = [])
    {
        $data['type'] = $type;
       
        if ($type == 'media')  $data['value'] = Media::tmp()->id;


        if ($type == 'content')    $data['value'] = Content::tmp()->id;


        return $data;
    }

    static function newdraft($type = 'string')
    {

        $wh = ['user_id' =>   Auth::id(), 'type' => $type];
      
        return static::where($wh)->first() ?? static::create(array_merge($wh, array_merge($wh, static::ddata($type,['code' => uniqid()]))));
    }

    static function has($code, $type = 'string')
    {
        $wh = ['code' => $code, 'type' => $type];
        return static::where($wh)->first() ?? static::create(array_merge($wh, array_merge($wh, static::ddata($type))));
    }
}
