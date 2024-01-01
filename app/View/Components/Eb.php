<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Eb extends Component
{
    public $id, $name, $embed;
    public function __construct($id = null, $name = null, $embed = null)
    {

        $this->id = $id ?? uniqid('embed');
        $this->name = $name;
        $this->embed = $embed;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $edit = route('x.embed.edit', $this->embed);
        $get = route('x.embed.edit', [$this->embed, 'get' => 'data']);
        $update = route('x.embed.update', $this->embed);
        $show = route('x.embed.show', $this->embed);
        $detect = route('x.embed.show', [$this->embed, 'get' => 'refs']);
        return view('components.eb', compact('edit', 'get', 'update', 'detect', 'show'));
    }
}
