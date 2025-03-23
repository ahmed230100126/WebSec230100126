<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'doLogin', 'register', 'doRegister']);
    }

    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->hasPermissionTo('delete_users')) {
            abort(403);
        }

        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function register()
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Assign admin role and permissions
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permissions = ['add_products', 'edit_products', 'delete_products'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $role->syncPermissions($permissions);
        $user->assignRole($role);

        return redirect("/");
    }

    public function login()
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');
        }
        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);
        return redirect("/");
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function profile(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach ($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = [];
        foreach (Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach (Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user)
    {
        if (auth()->id() != $user->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if (auth()->user()->hasPermissionTo('edit_users')) {
            $roles = Role::whereIn('id', $request->roles)->pluck('id')->toArray();
            $user->syncRoles($roles);

            $permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();
            $user->syncPermissions($permissions);

            Artisan::call('cache:clear');
        }

        return redirect(route('profile', ['user' => $user->id]));
    }

    public function updatePassword(Request $request, User $user = null)
    {
        $user = $user ?? Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
        ]);

        if (auth()->id() != $user->id && !auth()->user()->hasPermissionTo('change_password')) {
            abort(401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
