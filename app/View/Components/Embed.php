<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Embed extends Component
{
    public $id, $name, $value, $debug = true;
    public function __construct($name = null, $debug = true, $value = null)
    {
        $this->debug = $debug;
        $this->id = uniqid('embed');
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $edit = route('x.embed.edit', $this->value);
        $update = route('x.embed.update', $this->value);
        $show = route('x.embed.show', $this->value);
        $detect = route('x.embed.show', [$this->value, 'get' => 'refs']);
        return view('components.embed', compact('update', 'edit', 'show', 'detect'));
    }
}
