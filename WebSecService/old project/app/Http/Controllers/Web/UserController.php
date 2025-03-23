<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_users');
    }

    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.index', compact('users', 'roles', 'permissions'));
    }

    public function edit(Request $request, User $user = null)
    {
        $user = $user ?? new User();
        
        $roles = [];
        foreach(Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach(Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, $user)
    {
        $user = User::findOrFail($user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update roles
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        // Update permissions
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully.');
    }
} 