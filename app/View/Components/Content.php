<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
{
    public $id, $name, $value;
    public function __construct($name = null, $value = null)
    {
        $this->id = uniqid('content_');
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $addmedia = route('x.content.addmedia', $this->value);
        $edit = route('x.content.edit', $this->value);
        $update = route('x.content.update', $this->value);
        return view('components.content', compact('addmedia', 'edit', 'update'));
    }
}
