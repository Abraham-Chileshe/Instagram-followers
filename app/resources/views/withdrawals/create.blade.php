@extends('layouts.app')

@section('title', 'Request Withdrawal')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 600px; margin: 0 auto;">
        <div class="posts_container">
            <div class="stories" style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb;">
                <h3>Withdraw Earnings</h3>
                <p>Request a payout to your preferred payment method.</p>
            </div>

            <div class="posts" style="padding: 20px;">
                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 20px;">
                    <div
                        style="margin-bottom: 20px; text-align: center; background: #fafafa; padding: 15px; border-radius: 4px;">
                        <span style="display: block; color: #8e8e8e; font-size: 0.9rem;">Available Balance</span>
                        <span
                            style="display: block; font-size: 1.8rem; font-weight: bold; color: #262626;">{{ Auth::user()->balance_aed }}
                            AED</span>
                    </div>

                    <form action="{{ route('withdraw.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Amount (AED)</label>
                            <input type="number" name="amount_aed" min="100" step="0.01" class="form-control"
                                placeholder="Minimum 100 AED" required
                                style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                            @error('amount_aed')
                                <span style="color: #ed4956; font-size: 0.8rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required
                                style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                                <option value="usdt" {{ Auth::user()->payment_preference == 'usdt' ? 'selected' : '' }}>
                                    USDT (TRC20)</option>
                                <option value="bank" {{ Auth::user()->payment_preference == 'bank' ? 'selected' : '' }}>
                                    Bank Transfer</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Payment Details</label>
                            <textarea name="payment_details" rows="3" class="form-control"
                                placeholder="Enter wallet address or bank account details" required
                                style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">{{ Auth::user()->usdt_wallet_address }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; background: #0095f6; border: none; font-weight: bold; padding: 12px;">
                            Submit Request
                        </button>
                    </form>

                    <div style="margin-top: 20px; text-align: center;">
                        <a href="{{ route('withdraw.index') }}"
                            style="color: #0095f6; font-size: 0.9rem; text-decoration: none; font-weight: bold;">View
                            Request History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
