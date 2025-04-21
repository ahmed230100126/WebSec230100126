<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller {

	use ValidatesRequests;

    public function list(Request $request) {
        if(!auth()->user()->hasPermissionTo('show_users'))abort(401);
        $query = User::select('*');
        $query->when($request->keywords,
        fn($q)=> $q->where("name", "like", "%$request->keywords%"));
        $users = $query->get();
        return view('users.list', compact('users'));
    }

	public function register(Request $request) {
        return view('users.register');
    }

    public function doRegister(Request $request) {
        try {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
            
            // If validation fails, throw an exception that will be caught
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput($request->except(['password', 'password_confirmation']))
                    ->withErrors($validator);
            }

            // Create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->credits = 1000; // Give new customers some starting credits
            $user->save();

            // Assign the Customer role to new registrations
            $user->assignRole('Customer');

            // Send verification email - in a separate try-catch to handle email sending issues
            try {
                $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
                $link = route("verify", ['token' => $token]);
                Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
                
                return redirect('/')->with('success', 'Registration successful! Please check your email for verification.');
            } catch (\Exception $e) {
                // Log the email error
                \Log::error('Failed to send verification email: ' . $e->getMessage());
                
                return redirect('/')->with([
                    'warning' => 'Your account was created, but we could not send the verification email. Please try requesting a new verification email.',
                    'email' => $user->email
                ]);
            }

        } catch (\Exception $e) {
            // Return to the registration form with a generic error message
            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['generic_error' => 'Registration failed. Please check your information and try again.']);
        }
    }

    public function createEmployee(Request $request) {
        // Check if the user has permission to manage employees
        if(!auth()->user()->hasPermissionTo('manage_employees')) abort(401);

        return view('users.create_employee');
    }

    public function saveEmployee(Request $request) {
        // Check if the user has permission to manage employees
        if(!auth()->user()->hasPermissionTo('manage_employees')) abort(401);

        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        }
        catch(\Exception $e) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid employee information.');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Assign the Employee role
        $user->assignRole('Employee');

        return redirect()->route('users')->with('success', 'Employee created successfully');
    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request) {
        try {
            $data = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ])->validate();

            if (Auth::attempt($data)) {
                $user = User::where('email', $request->email)->first();
                
                if(!$user->email_verified_at) {
                    Auth::logout(); // Ensure they are logged out if not verified
                    
                    return redirect()->back()
                        ->withInput($request->only('email'))
                        ->with('email', $user->email) // Store email for the resend verification form
                        ->withErrors('Your email is not verified. Please verify your email before logging in.');
                }

                return redirect('/');
            }

            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid login credentials');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['generic_error' => 'Login failed. Please try again.']);
        }
    }

    public function doLogout(Request $request) {
        Auth::logout();
        return redirect('/');
    }

    public function verify(Request $request) {
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if(!$user) abort(401);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return view('users.verified', compact('user'));
    }

    /**
     * Resend verification email to the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerification(Request $request) {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->withInput(['email' => $email])
                ->withErrors('User not found.');
        }
        
        if ($user->email_verified_at) {
            return redirect()->back()->with('info', 'Email already verified. You can now log in.');
        }
        
        try {
            // Generate token and send verification email
            $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
            $link = route("verify", ['token' => $token]);
            Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
            
            return redirect()->back()->with([
                'success' => 'Verification email has been sent to your email address.',
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to resend verification email: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput(['email' => $email])
                ->withErrors('There was a problem sending the verification email. Please try again later.');
        }
    }

    public function profile(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

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

    public function save(Request $request, User $user) {

        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if(auth()->user()->hasPermissionTo('admin_users')) {

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }

     
        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function delete(Request $request, User $user) {

        if(!auth()->user()->hasPermissionTo('delete_users')) abort(401);
        //$user->delete();
        $user->delete();
        return redirect()->route('users');
    }

    
    public function editPassword(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user) {

        if(auth()->id()==$user?->id) {

            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if(!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {

                Auth::logout();
                return redirect('/');
            }
        }
        else if(!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); 
        $user->save();

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
       $userfacebook = Socialite::driver('facebook')->stateless()->user();

       $user = User::firstorCreate([
            ['facebook_id' => $userfacebook->getId()],
           'name' => $userfacebook->getName(),
           'email' => $userfacebook->getEmail(),
       ]);
       $user->assignRole('Customer'); // Assign the Customer role
       Auth::login($user, true); // Log the user in
       return redirect('/')->with('success', 'Logged in with Facebook successfully!');
    }

}
