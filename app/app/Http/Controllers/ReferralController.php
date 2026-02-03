<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $referrals = $user->referrals()->latest()->get();
        $totalReferralEarnings = $referrals->sum('balance_aed'); // This might need a more complex calculation based on split
        
        return view('referrals.index', compact('referrals', 'totalReferralEarnings'));
    }
}
