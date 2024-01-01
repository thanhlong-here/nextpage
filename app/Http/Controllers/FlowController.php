<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use App\Http\Requests\StoreFlowRequest;
use App\Http\Requests\UpdateFlowRequest;
use App\Models\Role;
use App\X\Detect;

class FlowController extends Controller
{

    public function fetch()
    {
        return Flow::published(['prefix' => request('prefix', 'web'), 'app_id' => request('app')])
            ->OrderByDesc('updated_at')
            ->cursorPaginate(100)->map(function ($item) {
                $item->edit = route('x.flow.edit', $item);
                $item->delete = route('x.flow.destroy', $item);
                $item->show = route('x.flow.show', $item);
                $item->roles = $item->is_public ? [] : $item->roles;
                return $item;
            });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = "web";
        $icon = "fe fe-compass";
        $create = route('x.flow.create');
        $fetch = route('x.flow.fetch');
        $card = 'res.wp.flow.card';
        return view('x.index', compact('name', 'icon', 'create', 'card', 'fetch'));
    }
    /**
     * Display a listing of the resource.
     */
    public function api()
    {
        $name = "api";
        $icon = "fe fe-codepen";
        $create = route('x.flow.create', ['prefix' => 'api']);
        $card = 'res.wp.flow.card';
        $fetch = route('x.flow.fetch', ['prefix' => 'api']);
        return view('x.index', compact('name', 'icon', 'create', 'card', 'fetch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $flow = Flow::newdraft(request('prefix', 'web'), request('app'));
        return $this->edit($flow);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlowRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Flow $flow)
    {
        if (request('get') == 'detect') {
            Detect::clear();
            ob_start();
            $flow->test();
            ob_end_clean();
            return Detect::refs();
        }
        return $flow->test();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flow $flow)
    {
        $editor = (object)[
            'code'  => $flow->code,
            'updated_at' => $flow->updated_at,
            'action'    => route('x.flow.update', $flow),
            'create' => route('x.flow.create', ['prefix' => $flow->prefix]),
            'fetch' => route('x.flow.fetch', ['prefix' => $flow->prefix, 'app' => $flow->app_id]),
            'show' => route('x.flow.show', $flow),
            'detect' => route('x.flow.show', [$flow, 'get' => 'detect'])
        ];
        $roles = Role::pluck('code', 'id');

        //if (request('ref')) return view('res.wp.flow.ref', compact('editor', 'flow', 'roles'));

        //     $fetch = route('x.flow.index', ['prefix' => $flow->prefix]);

        return view('x.flow.edit', compact('editor', 'flow', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlowRequest $request, Flow $flow)
    {
        $roles = $request->roles ? explode(",", $request->roles) : [];

        if (!$request->is_public) $flow->roles()->sync($roles);

        if ($flow->draft)  $flow->published_at = now();
        return [
            'status' =>  $flow->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flow $flow)
    {
        return [
            'status' => $flow->delete()
        ];
    }
}
