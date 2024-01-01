<?php

namespace App\Models\Unit;

use App\Models\Traits\AccessMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Media extends Model
{
    use HasFactory,AccessMedia;
    public $timestamps = false;
    protected $guarded  = ['id'];
    protected $attributes = ['type' => 'image/png'];
    
    public static function tmp()
    {
        return static::create();
    }

    function put($file = null)
    {
        if ($file) $file->storeAs('media', $this->name);
    }
    function exists()
    {
        return File::exists($this->path);
    }


    function remove()
    {
        if ($this->exists()) File::delete($this->path);
    }


    public function getContentAttribute()
    {
        if ($this->exists())
            return  File::get($this->path);
    }

    public function getPathAttribute()
    {
        return storage_path("app/media/$this->name");
    }

    public function getNameAttribute()
    {
        return $this->id . ".$this->extension";
    }

    public static function create(array $attributes = [])
    {
        $file = $attributes['file'] ?? null;
        if ($file) {
            $attributes['extension'] = $file->getClientOriginalExtension();
        }
        $model = static::query()->create($attributes);
        $model->put($file);
        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        $file = $attributes['file'];
        if ($file) {
            $attributes['extension'] = $file->getClientOriginalExtension();
        }
        parent::update($attributes);
        $this->put($file);
    }

    public function delete()
    {
        $this->remove();
        return parent::delete();
    }
}
