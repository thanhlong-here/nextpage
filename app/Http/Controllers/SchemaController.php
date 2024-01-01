<?php

namespace App\Http\Controllers;

use App\Models\Schema;
use App\Http\Requests\StoreSchemaRequest;
use App\Http\Requests\UpdateSchemaRequest;
use Illuminate\Support\Facades\Auth;

class SchemaController extends Controller
{

    public function fetch()
    {
        return Schema::published()->OrderByDesc('updated_at')->cursorPaginate(100)->map(function ($item) {
            $item->edit = route("x.schema.edit", $item);
            $item->delete = route("x.schema.destroy", $item);
            return $item;
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = "schema";
        $icon = "fe fe-package";
        $create = route('x.schema.create');
        $fetch = route('x.schema.fetch');
        return view('x.index', compact('name', 'icon', 'create', 'fetch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schema = Schema::newdraft();
        return $this->edit($schema);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchemaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Schema $schema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schema $schema)
    {
        $editor = (object)[
            'code'  => $schema->code,
            'updated_at' => $schema->updated_at,
            'action'    => route('x.schema.update', $schema),
            'create' => route('x.schema.create'),
            'create_mix' => route('x.schema.mix.create', $schema),
            'fetch' => route('x.schema.fetch'),
        ];
        $mix_fetch = route('x.schema.mix.index', $schema);

        // if (request('ref')) {
        //     return view('res.wp.schema.ref', compact('editor', 'schema', 'mix_fetch'));
        // }

        //$fetch = route('x.schema.index');

        return view('x.schema.edit', compact('editor', 'schema', 'mix_fetch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchemaRequest $request, Schema $schema)
    {

        if ($schema->draft)  $schema->published_at = now();
        return [
            'status' => $schema->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schema $schema)
    {
        return [
            'status' => $schema->delete()
        ];
    }
}
