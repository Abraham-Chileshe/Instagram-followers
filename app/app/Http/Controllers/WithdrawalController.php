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

    public function store(Request $request)
    {
        $request->validate([
            'amount_aed' => 'required|numeric|min:100', // Minimum withdrawal 100 AED
            'payment_method' => 'required|in:usdt,bank,cash',
            'payment_details' => 'required|string',
        ]);

        $user = Auth::user();

        // 0. Instagram Subscription Check
        if (!$user->is_subscribed_to_target) {
            return back()->withErrors(['amount_aed' => 'You must be subscribed to the target Instagram account to withdraw funds.']);
        }

        // 1. Join Date Restriction (Must be joined for at least 7 days)
        $joinDate = $user->created_at; // Using created_at as join date if joined_at is null
        if ($joinDate->gt(now()->subDays(7))) {
            $daysLeft = round(now()->diffInDays($joinDate->addDays(7)), 1);
            return back()->withErrors(['amount_aed' => "New accounts must wait 7 days before their first withdrawal. Please wait {$daysLeft} more days."]);
        }

        // 1. 7-Day Restriction Check (from last withdrawal)
        $lastWithdrawal = $user->withdrawals()->latest()->first();
        if ($lastWithdrawal && $lastWithdrawal->created_at->gt(now()->subDays(7))) {
            $daysLeft = round(now()->diffInDays($lastWithdrawal->created_at->addDays(7)), 1);
            return back()->withErrors(['amount_aed' => "You can only withdraw once every 7 days. Please wait {$daysLeft} more days."]);
        }

        // 2. Activity Check (Must have at least one approved task in the last 7 days)
        $recentApprovedTasks = $user->submissions()
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        if ($recentApprovedTasks === 0) {
            return back()->withErrors(['amount_aed' => 'Insufficient activity. You must complete at least one task every 7 days to qualify for withdrawals.']);
        }

        if ($user->balance_aed < $request->amount_aed) {
            return back()->withErrors(['amount_aed' => 'Insufficient balance.']);
        }

        // Calculate Payout based on method
        $payoutAmount = $request->amount_aed;
        if ($request->payment_method === 'usdt') {
            $payoutAmount = $request->amount_aed * 0.75;
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount_aed' => $request->amount_aed,
            'payout_amount' => $payoutAmount,
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
