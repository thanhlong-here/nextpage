<?php

namespace App\Models;

use App\Models\Traits\FetchData;
use App\Models\Traits\HasDraft;
use App\Models\Traits\HasTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Schema extends Model
{
    use HasFactory, HasDraft, HasTable;
    protected $guarded  = ['id'];
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];
    static public $field_types = [
        'string' => 'string',
        'number' => 'bigInteger',
        'datetime' => 'dateTime',

        'auth' => 'bigInteger',
        'media'  => 'bigInteger',
        'content' => 'bigInteger',
        'text' => 'mediumText',
    ];

    static function newdraft()
    {
        $wh = ['user_id' =>  Auth::id(), 'published_at' => null];
        return static::firstOrCreate($wh, array_merge(
            $wh,
            ['code' => uniqid()]
        ));
    }


    static function has($code)
    {
        $wh = ['code' => $code];
        return static::firstOrCreate($wh, array_merge(
            $wh,
            ['published_at' => now(),  'user_id' => Auth::id(),]
        ));
    }

    public function fields()
    {
        return $this->hasMany(SchemaField::class);
    }

    public function addField($data)
    {
        return SchemaField::create(array_merge($data, ['schema_id' => $this->id]));
    }

    public function mix()
    {
        return Mix::w($this);
    }

    static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->make();
        });

        static::deleted(function ($model) {
            $model->drop();
        });
    }
}
