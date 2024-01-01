<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Http\Requests\StoreAppRequest;
use App\Http\Requests\UpdateAppRequest;
use App\Models\Role;
use App\X\Detect;

class AppController extends Controller
{

    public function fetch()
    {
        return App::published()->OrderByDesc('updated_at')->cursorPaginate(100)->map(function ($item) {
            $item->edit = route('x.app.edit', $item);
            $item->delete = route('x.app.destroy', $item);
            $item->show = route('x.app.show', $item);
            return $item;
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = 'app';
        $icon = 'fe fe-airplay';
        $create = route('x.app.create');
        $fetch = route('x.app.fetch');
        return view('x.app.index', compact('name', 'icon', 'create', 'fetch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return $this->edit(App::newdraft());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(App $app)
    {
        return redirect(route('x.flow.show', $app->main_screen));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(App $app)
    {
        $editor = (object)[
            'code'  => $app->code,
            'updated_at' => $app->updated_at,
            'action'    => route('x.app.update', $app),
            'create' => route('x.app.create'),
            'fetch' => route('x.app.fetch'),
            'show' => route('x.app.show', $app),
            'newscreen' => route('x.flow.create', ['prefix' => 'app', 'app' => $app->id]),
            'fetch_screens' => route('x.flow.fetch', ['prefix' => 'app', 'app' => $app->id])
        ];
        return view('x.app.edit', compact('editor', 'app'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppRequest $request, App $app)
    {

        if ($app->draft)  $app->published_at = now();
        return [
            'status' =>  $app->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(App $app)
    {
        return [
            'status' => $app->delete()
        ];
    }
}
