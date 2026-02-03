<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'usdt_wallet_address' => 'nullable|string|max:255',
            'payment_preference' => 'required|in:usdt,bank',
        ]);

        Auth::user()->update($request->only(['usdt_wallet_address', 'payment_preference']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        // Log out user
        Auth::logout();

        // Delete user record
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/access-code')->with('success', 'Your account has been deleted.');
    }
}
