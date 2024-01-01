<?php

namespace App\Http\Controllers;

use App\Models\Schema;
use App\Models\SchemaField;
use Illuminate\Http\Request;

class SchemaFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Schema $schema)
    {

        return $schema->fields->map(function ($item) {
            $item->delete = route('x.field.destroy', $item);
            return $item;
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**`
     * Store a newly created resource in storage.
     */
    public function store(Schema $schema, Request $request)
    {
        return [
            'status' =>   $schema->addField([
                'code' => $request->field_code,
                'type' => $request->field_type
            ])
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(SchemaField $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchemaField $schemaField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchemaField $field)
    {
        $field->update([
            'code' => $request->field_code,
            'type' => $request->field_type
        ]);

        return [
            'status' => true,
            'type' => 'success',
            'msg' => "updated",
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchemaField $field)
    {
        if ($field->delete()) {
            return [
                'status' => true,
                'type' => 'success',
                'msg' =>  "Deleted",
            ];
        }
    }
}
