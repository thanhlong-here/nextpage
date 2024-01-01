<?php

namespace App\Http\Controllers;

use App\Models\Unit\Embed;
use App\Http\Requests\StoreEmbedRequest;
use App\Http\Requests\UpdateEmbedRequest;

class EmbedController extends Controller
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
    public function store(StoreEmbedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Embed $embed)
    {

     
        //dd($embed);
        return (request('get') == 'refs') ?  $embed->detect() : $embed->test();
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Embed $embed)
    {
        return $embed;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmbedRequest $request, Embed $embed)
    {

        return [
            'status' => $embed->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Embed $embed)
    {
        //
    }
}
