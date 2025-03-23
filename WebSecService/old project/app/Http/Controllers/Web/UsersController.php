use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Artisan;

class UsersController extends Controller
{
    public function profile(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
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
        if (auth()->id() != $user?->id && !auth()->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $roles = [];
        foreach (Role::all() as $role) {
            $role->taken = $user->hasRole($role->name);
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
        if (auth()->id() != $user->id && !auth()->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if (auth()->user()->hasPermissionTo('edit_users')) {
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);
            Artisan::call('cache:clear');
        }

        return redirect(route('profile', ['user' => $user]));
    }

    // Other methods...
}