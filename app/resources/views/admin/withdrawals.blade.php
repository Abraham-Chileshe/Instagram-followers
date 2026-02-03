@extends('layouts.app')

@section('title', 'Admin - Withdrawals')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories" style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb;">
                <h3>Pending Withdrawals</h3>
                <p>Review and process user payout requests.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="admin-content" style="padding: 20px;">
                @forelse($withdrawals as $withdrawal)
                    <div class="post_cart"
                        style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; margin-bottom: 24px; padding: 20px;">
                        <div style="display: flex; gap: 20px; justify-content: space-between; align-items: flex-start;">
                            <div style="flex: 2;">
                                <h5 style="margin: 0 0 10px 0;">User: {{ $withdrawal->user->name }}</h5>
                                <p style="margin: 0 0 5px 0;"><strong>Amount:</strong> <span
                                        style="font-size: 1.2rem; color: #262626; font-weight: bold;">{{ $withdrawal->amount_aed }}
                                        AED</span></p>
                                <p style="margin: 0 0 5px 0;"><strong>Method:</strong>
                                    {{ strtoupper($withdrawal->payment_method) }}</p>
                                <p style="margin: 0 0 15px 0;"><strong>Details:</strong> <code
                                        style="background: #fafafa; padding: 5px; border-radius: 4px; display: block; margin-top: 5px;">{{ $withdrawal->payment_details }}</code>
                                </p>
                                <p style="margin: 0; font-size: 0.8rem; color: #8e8e8e;">Requested
                                    {{ $withdrawal->created_at->diffForHumans() }}</p>
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success"
                                        style="width: 100%; font-weight: bold; background: #47a138; border: none; color: white; padding: 12px; border-radius: 4px;">
                                        Mark as Processed
                                    </button>
                                </form>
                                <p style="font-size: 0.75rem; color: #8e8e8e; margin-top: 10px;">Ensure payment is sent
                                    before marking as processed.</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px;">
                        <p style="color: #8e8e8e;">No pending withdrawals to process.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
