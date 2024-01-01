<?php

namespace App\Http\Controllers;

use App\Models\Unit\Media;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {
        //
    }

    public function open(Media $medi)
    {
        if ($medi->is_open) return $this->show($medi);
    }
    /**
     * Display the specified resource.
     */
    public function show(Media $medi)
    {

        if (!$medi->exists()) return abort(404);
        return response($medi->content)->header('Content-type', 'image/png');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $medi)
    {

        if ($medi->exists()) {
            $medi->show = route('x.medi.show', [$medi, 'ref' => uniqid()]);
        }

        return $medi;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, Media $medi)
    {

        if ($request->act == 'reset') {
            $medi->remove();
            return ['status' => true];
        }

        $input = $request->input();
        if ($request->file) {
            $input['file'] = $request->file;
        }
        return [
            'status' => $medi->update($input)
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $medi)
    {
        //
    }
}
