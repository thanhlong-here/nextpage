<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function fetch()
    {
        return User::get()->map(function ($item) {
            $item->edit = route('x.user.edit', $item);
            $item->is_root = $item->getIsRootAttribute();
            if (!$item->is_root)
                $item->delete = route('x.user.destroy', $item);
            $item->pass = route('x.user.edit', [$item, 'view' => 'changepass']);
            return $item;
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = "User";
        $icon = 'fe fe-users';
        $fetch = route('x.user.fetch');
        $create = route('x.user.create');
        $classmodal = '';
        return view('x.user.index', compact('name','icon', 'fetch', 'create','classmodal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('code', 'id');
        return view('x.user.register', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $roles = $request->roles ? explode(",", $request->roles) : [];
        $user->roles()->sync($roles);

        return [
            'status' => true,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (request('view') == 'changepass')   return view('x.user.changepass', compact('user'));
        $roles = Role::pluck('code', 'id');
        return view('x.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->action == 'changepass') {

            $user->password = Hash::make($request->password);
            return [
                'status' =>  $user->update(),
            ];
        }

        return [
            'status' =>  $user->update($request->input()),
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return [
            'status' => $user->delete()
        ];
    }
}
