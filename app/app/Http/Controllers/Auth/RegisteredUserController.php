<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'payment_preference' => ['required', 'string', 'in:usdt,bank'],
            'usdt_wallet_address' => ['nullable', 'string', 'required_if:payment_preference,usdt'],
        ]);

        // RECRUITER LINKING LOGIC
        // We look for the pending access code in the session
        $pendingCode = Session::get('pending_access_code');
        $recruiterId = null;

        if ($pendingCode) {
            $accessCode = AccessCode::where('code', $pendingCode)->first();
            if ($accessCode && $accessCode->recruiter_id) {
                $recruiterId = $accessCode->recruiter_id;
            }
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(16)), // Random password since we use code-based auth
            'payment_preference' => $request->payment_preference,
            'usdt_wallet_address' => $request->usdt_wallet_address,
            'recruiter_id' => $recruiterId, // LINK TO RECRUITER
            'balance_aed' => 0,
            'joined_at' => now(),
            'role' => 'user',
        ]);

        // Link the access code to this new user and mark as used
        if ($pendingCode) {
            $accessCode = AccessCode::where('code', $pendingCode)->first();
            if ($accessCode) {
                $accessCode->update([
                    'user_id' => $user->id,
                    'status' => 'used',
                ]);
                Session::put('active_access_code', $accessCode->code);
            }
        }

        Auth::login($user);
        Session::forget('pending_access_code');

        return redirect()->route('home');
    }
}
