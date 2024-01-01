<?php

namespace App\Http\Controllers;

use App\Models\Simple;
use App\Http\Requests\StoreSimpleRequest;
use App\Http\Requests\UpdateSimpleRequest;
use Illuminate\Support\Facades\Auth;

class SimpleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function fetch()
    {
        return Simple::published(['type' => request('type', 'string')])
            ->OrderByDesc('updated_at')
            ->cursorPaginate(100)->map(function ($item) {
                $item->edit = route("x.simple.edit", $item);
                $item->delete = route("x.simple.destroy", $item);
                return $item;
            });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = "Label";
        $icon = "fe fe-tag";
        $create = route('x.simple.create', ['type' => 'string']);
        $fetch = route('x.simple.fetch', ['type' => 'string']);
        return view('x.index', compact('name', 'icon', 'create', 'fetch'));
    }
    public function media()
    {
        $name = "Media";
        $icon = "fe fe-image";
        $create = route('x.simple.create', ['type' => 'media']);
        $fetch = route('x.simple.fetch', ['type' => 'media']);
        return view('x.index', compact('name', 'icon', 'create', 'fetch'));
    }

    public function content()
    {
        $name = "Content";
        $icon = "fe fe-file-text";
        $create = route('x.simple.create', ['type' => 'content']);
        $fetch = route('x.simple.fetch', ['type' => 'content']);
        return view('x.index', compact('name', 'icon', 'create', 'fetch'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $simple = Simple::newdraft(request('type', 'string'));
        return $this->edit($simple);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSimpleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Simple $simple)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Simple $simple)
    {
        $editor = (object)[
            'code'  => $simple->code,
            'updated_at' => $simple->updated_at,
            'action'    => route('x.simple.update', $simple),
            'create' => route('x.simple.create'),
            'fetch' => route('x.simple.fetch', ['type' => $simple->type]),
        ];

        if (request('ref')) return view('res.wp.simple.ref', compact('editor', 'simple'));

        return view('x.simple.edit', compact('editor', 'simple'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSimpleRequest $request, Simple $simple)
    {
        if ($simple->draft)  $simple->published_at = now();

        return [
            'status' =>   $simple->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Simple $simple)
    {
        return [
            'status' => $simple->delete()
        ];
    }
}
