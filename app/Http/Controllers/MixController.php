<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMixRequest;
use App\Http\Requests\UpdateMixRequest;
use App\Models\Schema;
use Illuminate\Support\Facades\Auth;

class MixController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Schema $schema)
    {
        return $schema->mix()->fetch();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Schema $schema)
    {
        $mix = $schema->mix()->newdraft(Auth::id());
        return $this->edit($schema, $mix->id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMixRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($mix)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schema $schema, $mix)
    {
        $mix = $schema->mix()->find($mix);
        $fields = $schema->fields;
        $editor = (object)[
            'code'  => $mix->code,
            'updated_at' => $mix->updated_at,
            'action'    => route('x.schema.mix.update', [$schema, $mix]),
            'create' => route('x.schema.mix.create', $schema),
            'fetch' =>  route('x.schema.mix.index', $schema)
        ];

        return view('x.mix.edit', compact('schema', 'editor', 'fields', 'mix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMixRequest $request, Schema $schema, $mix)
    {
        $mix = $schema->mix()->find($mix);
        if ($mix->draft)  $mix->published_at = now();
        return [
            'status' => $mix->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schema $schema, $mix)
    {
        $mix = $schema->mix()->find($mix);
        return [
            'status' => $mix->delete()
        ];
    }
}
