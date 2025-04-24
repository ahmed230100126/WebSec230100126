<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function customers()
    {
        // Get all users with Customer role
        $customers = User::role('Customer')->get();

        return view('users.customers', compact('customers'));
    }

    /**
     * Show user profile
     */
    public function profile(User $user = null)
    {
        // If no user ID provided or user not found, show current user's profile
        if (!$user || $user->id === null) {
            $user = Auth::user();

            // Redirect if not logged in
            if (!$user) {
                return redirect()->route('login');
            }
        }

        // Get permissions for display
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

    /**
     * Show form to add credits to a user
     */
    public function showAddCredits(User $user)
    {
        return view('users.add_credits', compact('user'));
    }

    /**
     * Add credits to a user
     */
    public function addCredits(Request $request, User $user)
    {
        // Check if current user has role Admin or Employee
        if (!Auth::user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(403, 'Unauthorized action');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $request->input('amount');

        // Additional check to ensure positive value
        if ($amount <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Credit amount must be positive.');
        }

        $user->credits += $amount;
        $user->save();

        return redirect()->route('users.customers')
            ->with('success', "Successfully added {$amount} credits to {$user->name}'s account.");
    }

    /**
     * Reset user credits to zero
     */
    public function resetCredits(User $user)
    {
        // Check if current user has role Admin or Employee
        if (!Auth::user()->hasAnyRole(['Employee'])) {
            abort(403, 'Unauthorized action');
        }

        // Ensure target user is a customer
        if (!$user->hasRole('Customer')) {
            return redirect()->back()->with('error', 'Credits can only be reset for customer accounts.');
        }
        
        // Save the current credit amount for the message
        $oldCredits = $user->credits;
        
        // Reset credits to zero
        $user->credits = 0;
        $user->save();
        
        return redirect()->route('users.customers')
            ->with('success', "Successfully reset {$user->name}'s credits from \${$oldCredits} to \$0.");
    }

    /**
     * Show form to create a new employee
     */
    public function createEmployee()
    {
        return view('users.create_employee');
    }

    /**
     * Store a new employee
     */
    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the Employee role
        $user->assignRole('Employee');

        return redirect()->route('users')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Delete a customers
     */
    public function delete(Request $request, User $user) 
    {
        // Ensure we're not deleting our own account
        if(auth()->id() === $user->id) {
            return redirect()->route('users.customers')
                ->with('error', 'You cannot delete your own account.');
        }
        
        // Prevent admins from deleting other admins
        if(auth()->user()->hasRole('Admin') && $user->hasRole('Admin')) {
            return redirect()->route('users.customers')
                ->with('error', 'Admins cannot delete other admin accounts.');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('users.customers')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Redirect the user to GitHub authentication page
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle the callback from GitHub
     */
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            
            // Check if this user already exists with this GitHub ID
            $user = User::where('github_id', $githubUser->getId())->first();
            
            if (!$user) {
                // Check if there's a user with the same email
                $user = User::where('email', $githubUser->getEmail())->first();
                
                if (!$user) {
                    // Create a new user
                    $user = User::create([
                        'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                        'email' => $githubUser->getEmail(),
                        'password' => Hash::make(Str::random(16)), // Random password
                        'github_id' => $githubUser->getId(),
                        'credits' => 0,
                        'state' => 'active',
                    ]);
                    
                    // Assign Customer role to new users
                    $user->assignRole('Customer');
                } else {
                    // Update existing user with GitHub ID
                    $user->github_id = $githubUser->getId();
                    $user->save();
                }
            }
            
            // Check if user is blocked
            if ($user->state === 'blocked') {
                return redirect()->route('login')
                    ->with('error', 'Your account has been blocked. Please contact support.');
            }
            
            // Log in the user
            Auth::login($user);
            
            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'GitHub authentication failed: ' . $e->getMessage());
        }
    }

    public function toggleBlockStatus(User $user)
    {
        if (!Auth::user()->hasPermissionTo('block_users')) {
            abort(403, 'Unauthorized action');
        }

        if ($user->state == "blocked") {
            $user->state = "active";
            $message = "User {$user->name} has been unblocked successfully.";
        } else {
            $user->state = "blocked";
            $message = "User {$user->name} has been blocked successfully.";
        }
        
        $user->save();
        
        return redirect()->route('users.customers')
            ->with('success', $message);
    }
}
