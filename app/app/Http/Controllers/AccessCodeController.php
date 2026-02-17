<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccessCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccessCodeController extends Controller
{
    public function show()
    {
        return view('auth.access-code');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // We NO LONGER restore the access code session here to strictly follow
            // the "single-session" requirement. Users must enter a code to proceed.
            // Only permanent codes could be exception, but we keep it simple.

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $accessCode = AccessCode::where('code', $request->code)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$accessCode) {
            return back()->withErrors(['code' => 'Invalid or expired access code.']);
        }

        // For MVP, if code is valid, we might link it to a user or create a temporary session
        // If it's the first time, maybe we need to create a user.
        // Let's assume for now we just log them in as a specific user if the code is linked,
        // or redirect to registration if not.
        
        if ($accessCode->user_id) {
            Auth::loginUsingId($accessCode->user_id);
        } else {
            // Need to create a user or redirect to signup
            // For now, let's redirect to signup with the code in session
            Session::put('pending_access_code', $accessCode->code);
            return redirect()->route('register');
        }

        // Mark code as used ONLY if it's not a permanent code (expires_at is not null)
        if ($accessCode->expires_at !== null) {
            $accessCode->update(['status' => 'used']);
        }
        
        Session::put('active_access_code', $accessCode->code);

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('active_access_code');
        return redirect()->route('access-code.show');
    }

    public function generateForUser()
    {
        $user = Auth::user();
        
        // Generate a random code
        $code = strtoupper(\Illuminate\Support\Str::random(3)) . '-' . rand(100, 999);
        
        // Create the code linked to this user as the recruiter
        AccessCode::create([
            'code' => $code,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
            'recruiter_id' => $user->id, // LINK RECRUITER
        ]);

        return back()->with('success', "Invite code generated: $code");
    }
}
