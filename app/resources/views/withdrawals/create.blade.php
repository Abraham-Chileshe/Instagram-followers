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

                        @php
                            $joinDate = Auth::user()->created_at;
                            $canWithdrawAt = $joinDate->addDays(7);
                            $isRestricted = now()->lt($canWithdrawAt);
                        @endphp

                        @if ($isRestricted)
                            <div
                                style="background: #fff4f4; color: #ed4956; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid #ed4956;">
                                <strong>Account Restricted:</strong> New accounts must wait 7 days before their first
                                withdrawal.
                                <br>Eligible on: {{ $canWithdrawAt->format('M d, Y') }}
                                ({{ round(now()->diffInDays($canWithdrawAt), 1) }} days left)
                            </div>
                        @endif

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Amount (AED)</label>
                            <input type="number" name="amount_aed" id="amount_input" min="100" step="0.01"
                                class="form-control" placeholder="Minimum 100 AED" required
                                style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                            @error('amount_aed')
                                <span style="color: #ed4956; font-size: 0.8rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Payment Method</label>
                            <select name="payment_method" id="payment_method_select" class="form-control" required
                                style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                                <option value="usdt">USDT (TRC20) - 75% Payout</option>
                                <option value="bank">Bank Transfer - 100% Payout</option>
                                <option value="cash">Cash (Office) - 100% Payout</option>
                            </select>
                        </div>

                        <div id="payout_info"
                            style="margin-bottom: 20px; padding: 15px; background: #f0f9ff; border-radius: 4px; border: 1px solid #bae6fd; display: none;">
                            <span style="display: block; font-size: 0.9rem; color: #0369a1;">Estimated Payout:</span>
                            <span id="estimated_payout" style="font-size: 1.2rem; font-weight: bold; color: #0369a1;">0.00
                                AED</span>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Payment Details</label>
                            <textarea name="payment_details" rows="3" class="form-control"
                                placeholder="Enter wallet address or bank account details" required
                                style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" {{ $isRestricted ? 'disabled' : '' }}
                            style="width: 100%; background: {{ $isRestricted ? '#ccc' : '#0095f6' }}; border: none; font-weight: bold; padding: 12px; cursor: {{ $isRestricted ? 'not-allowed' : 'pointer' }}">
                            {{ $isRestricted ? 'Withdrawal Locked' : 'Submit Request' }}
                        </button>
                    </form>

                    <script>
                        const amountInput = document.getElementById('amount_input');
                        const methodSelect = document.getElementById('payment_method_select');
                        const payoutInfo = document.getElementById('payout_info');
                        const estimatedPayout = document.getElementById('estimated_payout');

                        function updatePayout() {
                            const amount = parseFloat(amountInput.value) || 0;
                            const method = methodSelect.value;
                            let payout = amount;

                            if (method === 'usdt') {
                                payout = amount * 0.75;
                            }

                            if (amount >= 100) {
                                payoutInfo.style.display = 'block';
                                estimatedPayout.innerText = payout.toFixed(2) + ' AED';
                            } else {
                                payoutInfo.style.display = 'none';
                            }
                        }

                        amountInput.addEventListener('input', updatePayout);
                        methodSelect.addEventListener('change', updatePayout);
                    </script>

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
