<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Media extends Component
{
    public $id, $name, $value;
    public function __construct($name = null, $value = null)
    {
        $this->id = uniqid('media_');
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $edit = route('x.medi.edit', $this->value);
        $update = route('x.medi.update', $this->value);
        return view('components.media', compact('edit', 'update'));
    }
}
