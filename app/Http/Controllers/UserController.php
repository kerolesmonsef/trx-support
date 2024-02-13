<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService
    )
    {
        $this->middleware("can:users");
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return $this->edit(new User());
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $this->permissionService->syncPermission($user, request('permissions', []));

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.add_edit_user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = array_filter($request->all());
        $user->update($data);
        $this->permissionService->syncPermission($user, request('permissions', []));
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
