<?php

namespace App\View\Components;

use App\Models\Schema as mSchema;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Schema extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $value;
    public function __construct($value = null)
    {
        $this->id = uniqid('schema_');
        $this->value = $value;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $types = mSchema::$field_types;

        $fetch = route('x.schema.field.index', $this->value);

        $store =  route('x.schema.field.store', $this->value);
        $update = route('x.field.update', $this->value);
        return view('components.schema', compact('types', 'store', 'update', 'fetch'));
    }
}
