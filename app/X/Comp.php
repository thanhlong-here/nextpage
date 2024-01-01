<?php

namespace App\X;

use App\Models\Unit\Embed;
use Illuminate\Support\Facades\File;

class Comp
{
    protected $source, $name, $path, $type;
    function __construct(Embed $embed)
    {
        $this->name = $embed->type . $embed->id;
        $this->source = $embed->source;
        $this->type = $embed->type;

        $ext = $this->type == 'ui' ? '.blade.php' : '.php';


        $this->path = storage_path('app/embed/' . $this->name . $ext);
    }

    public function delete()
    {
        if (File::exists($this->path)) File::delete($this->path);
    }

    public function save()
    {
        return File::put($this->path, $this->source);
    }

    public function run($x = null)
    {


        if (empty($this->source)) return;
        if (!File::exists($this->path)) File::put($this->path, $this->source);
        $run =  $this->type . "Run";
        return $this->$run($x);
    }

    function uiRun($x = null)
    {
        return view($this->name, $x);
    }

    function actRun($x = null)
    {
       
        return require_once $this->path;
    }
}
