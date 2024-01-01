<?php

namespace App\Models;

use App\Models\Traits\HasDraft;
use App\Models\Unit\Content;
use App\Models\Unit\Media;
use App\X\Detect;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Mix extends Model
{
    use HasFactory, HasDraft;
    protected $table = null;
    protected $guarded  = ['id'];
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'published_at' => 'datetime:Y-m-d h:i:s',
    ];
    public function newdraft($uid)
    {
        $wh = ['user_id' => $uid, 'published_at' => null];
        $first = static::where($wh)->first();

        if (isset($first)) return $first;

        return static::create(array_merge($wh, ['code' => uniqid()]));
    }


    public function fetch()
    {
        return $this->published()->OrderByDesc('updated_at')->cursorPaginate(100)->map(function ($item) {
            $item->edit = route("x.schema.mix.edit", [$item->schema, $item]);
            $item->delete = route("x.schema.mix.destroy", [$item->schema, $item]);
            return $item;
        });
    }

    public function getSchemaIdAttribute()
    {
        return  Str::of($this->table)->ltrim('_x');
    }

    public function getSchemaAttribute()
    {
        return Schema::find($this->schema_id);
    }

    function fields($type = null)
    {
        $fields = $this->schema->fields;
        return $type ? $fields->where('type', $type)->all() : $fields;
    }

    function default()
    {
        $data = [];
        foreach ($this->fields('media') as $media) {
            $code = $media->code;
            if (empty($this->$code)) $data[$code] = Media::tmp()->id;
        }
        foreach ($this->fields('content') as $content) {
            $code = $content->code;
            if (empty($this->$code)) $data[$code] = Content::tmp()->id;
        }
        return $data;
    }

    public function val($field)
    {
        return $this->$field;
    }

    public function find($id, $columns = ['*'])
    {
        $model = parent::find($id, $columns);
        $data = $model->default();
        if ($data) $model->update($data);
        return $model;
    }

    public static function w($schema)
    {
        $model =  new static();
        $model->setTable($schema->xtable());
        return $model;
    }

    public function setRefAttribute($value)
    {
        $this->ref = $value;
    }

    function has($code)
    {
        $wh = ['code' => $code];
        $first = $this->firstOrCreate(
            $wh,
            array_merge(
                $wh,
                ['published_at' => now(),  'user_id' => Auth::id() ?? null,]
            )
        );
        Detect::add("Mix::$code", route('x.schema.mix.edit', [$this->schema_id, $first]));
        return $first;
    }
}
