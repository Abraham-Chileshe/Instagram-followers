@extends('layouts.app')

@section('title', 'Withdrawal History')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories"
                style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">Withdrawal History</h3>
                <a href="{{ route('withdraw.create') }}" class="btn btn-primary"
                    style="background: #0095f6; border: none; font-weight: bold; font-size: 0.9rem;">New Request</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="withdrawal-content" style="padding: 20px;">
                @forelse($withdrawals as $withdrawal)
                    <div class="post_cart"
                        style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; margin-bottom: 15px; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span
                                style="display: block; font-weight: bold; font-size: 1.1rem;">{{ $withdrawal->amount_aed }}
                                AED</span>
                            <span style="color: #8e8e8e; font-size: 0.8rem;">Method:
                                {{ strtoupper($withdrawal->payment_method) }}</span>
                            <span
                                style="display: block; color: #8e8e8e; font-size: 0.75rem;">{{ $withdrawal->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span class="badge"
                                style="
                            padding: 5px 12px; 
                            border-radius: 20px; 
                            font-size: 0.8rem; 
                            font-weight: bold;
                            @if ($withdrawal->status == 'pending') background: #fff8e1; color: #fbc02d; border: 1px solid #fbc02d;
                            @elseif($withdrawal->status == 'approved') background: #e8f5e9; color: #4caf50; border: 1px solid #4caf50;
                            @else background: #ffebee; color: #f44336; border: 1px solid #f44336; @endif
                        ">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px;">
                        <p style="color: #8e8e8e;">No withdrawal requests found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
