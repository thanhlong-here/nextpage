<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Http\Requests\StoreCommandRequest;
use App\Http\Requests\UpdateCommandRequest;
use App\X\Detect;

class CommandController extends Controller
{

    public function fetch()
    {
        return Command::published(['prefix' => request('prefix', 'act')])
            ->OrderByDesc('updated_at')
            ->cursorPaginate(100)
            ->map(function ($item) {
                $item->edit = route("x.command.edit", $item);
                $item->delete = route("x.command.destroy", $item);
                return $item;
            });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = "Act";
        $icon = "fe fe-cpu";
        $create = route('x.command.create');
        $fetch = route('x.command.fetch');
        return view('x.index', compact('name', 'icon', 'create', 'fetch'));
    }

    /**
     * Display a listing of the resource.
     */
    public function ui()
    {
        $name = "ui";
        $icon = "fe fe-layers";
        $create = route('x.command.create', ['prefix' => 'ui']);
        $fetch = route('x.command.fetch', ['prefix' => 'ui']);
        return view('x.index', compact('name', 'icon', 'create', 'fetch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $command = Command::newdraft(request('prefix', 'act'));

        return $this->edit($command);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommandRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Command $command)
    {

        if (request('get') == 'detect') {
            Detect::clear();
            ob_start();
            $command->test();
            ob_end_clean();
            return Detect::refs();
        }
        return $command->test();

        //if ($this->embed('test')->source) return $this->embed('test')->run();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Command $command)
    {

        $editor = (object)[
            'code'  => $command->code,
            'updated_at' => $command->updated_at,
            'action'    => route('x.command.update', $command),
            'create' => route('x.command.create'),
            'fetch' => route('x.command.fetch', ['prefix' => $command->prefix]),
            'show' => route('x.command.show', $command),
            'detect' => route('x.command.show', [$command, 'get' => 'detect'])
        ];

        return view('x.command.edit', compact('editor', 'command'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommandRequest $request, Command $command)
    {

        if ($command->draft)  $command->published_at = now();
        //$command->embed->update($request->input());
        return [
            'status' =>   $command->update($request->input())
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Command $command)
    {
        return [
            'status' => $command->delete()
        ];
    }
}
