<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{

    public function fetch()
    {
        return Role::get()->map(function ($item) {
            $item->edit = route('x.role.edit', $item);
            $item->delete = route('x.role.destroy', $item);
            return $item;
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = "Role";
        $icon = 'fe fe-lock';
        $create = route('x.role.create');
        $fetch = route('x.role.fetch');
        $classmodal = '';
        return view('x.index', compact('name', 'icon', 'create', 'fetch','classmodal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $editor = (object)[
            'code'  => uniqid('role_'),
            'description'  => old('description', ''),
            'action'    => route('x.role.store'),
            'method' => "POST",
        ];
        return view('x.role.edit', compact('editor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        return [
            'status' =>  Role::create($request->input()),
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $editor = (object)[
            'code'  => $role->code,
            'description'  => old('description', $role->description),
            'updated_at' => $role->updated_at,
            'action'    => route('x.role.update', $role),
            'method' => "PUT",
        ];
        return view('x.role.edit', compact('editor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        return [
            'status' =>  $role->update($request->input()),
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {

        return [
            'status' =>  $role->delete()

        ];
    }
}
