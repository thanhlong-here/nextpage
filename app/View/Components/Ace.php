<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ace extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $name;
    public function __construct($name = null)
    {
        $this->id = uniqid('ace_');
        $this->name = $name;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ace');
    }
}
