<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Auth::user()->withdrawals()->latest()->get();
        return view('withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        return view('withdrawals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount_aed' => 'required|numeric|min:100', // Minimum withdrawal 100 AED
            'payment_method' => 'required|in:usdt,bank',
            'payment_details' => 'required|string',
        ]);

        $user = Auth::user();

        if ($user->balance_aed < $request->amount_aed) {
            return back()->withErrors(['amount_aed' => 'Insufficient balance.']);
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount_aed' => $request->amount_aed,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_details' => $request->payment_details,
        ]);

        // We don't deduct balance yet, only on approval
        // Or we can deduct now and refund on rejection. 
        // Let's deduct now for better UX (lock the funds).
        $user->decrement('balance_aed', $request->amount_aed);

        return redirect()->route('withdraw.index')->with('success', 'Withdrawal request submitted successfully!');
    }
}
