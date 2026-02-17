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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'password' => Hash::make($request->password),
            'payment_preference' => $request->payment_preference,
            'usdt_wallet_address' => $request->usdt_wallet_address,
            'recruiter_id' => $recruiterId, // LINK TO RECRUITER
            'balance_aed' => 0,
            'joined_at' => now(),
            'role' => 'user',
        ]);

        // Link the access code to this new user and mark as used (only if it's an expiring code)
        if ($pendingCode) {
            $accessCode = AccessCode::where('code', $pendingCode)->first();
            if ($accessCode) {
                $updateData = ['user_id' => $user->id];
                
                // Only mark as used if it's not a permanent code (expires_at is not null)
                if ($accessCode->expires_at !== null) {
                    $updateData['status'] = 'used';
                }
                
                $accessCode->update($updateData);
                Session::put('active_access_code', $accessCode->code);
            }
        }

        Auth::login($user);
        Session::forget('pending_access_code');

        return redirect()->route('home');
    }
}
