@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="width: 100%; max-width: 100%;">
            <div class="stories" style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb;">
                <h3 style="font-size: 1.5rem;">Profile Settings</h3>
                <p style="font-size: 1rem;">Manage your account and payment details.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-content" style="padding: 20px;">
                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px; margin-bottom: 25px;">
                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                        <img src="{{ asset('images/profile_img.jpg') }}" class="circle"
                            style="width: 100px; height: 100px; margin-right: 25px;">
                        <div>
                            <h4 style="margin: 0; font-size: 1.8rem;">{{ Auth::user()->name }}</h4>
                            <p style="margin: 5px 0 0 0; color: #8e8e8e; font-size: 1rem;">Joined
                                {{ Auth::user()->created_at->format('M Y') }}</p>
                        </div>
                    </div>

                    <div
                        style="display: flex; justify-content: space-around; background: #fafafa; padding: 20px; border-radius: 4px;">
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-weight: bold; font-size: 1.8rem;">{{ Auth::user()->balance_aed }}
                                AED</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Balance</span>
                        </div>
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-weight: bold; font-size: 1.8rem;">{{ Auth::user()->referrals()->count() }}</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Recruits</span>
                        </div>
                    </div>
                </div>

                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px;">
                    <h4 style="margin-bottom: 20px; font-size: 1.3rem;">Payment Details</h4>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">Preferred
                                Payment
                                Method</label>
                            <select name="payment_preference"
                                style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;">
                                <option value="usdt" {{ Auth::user()->payment_preference == 'usdt' ? 'selected' : '' }}>
                                    USDT (Crypto)</option>
                                <option value="bank" {{ Auth::user()->payment_preference == 'bank' ? 'selected' : '' }}>
                                    Bank Transfer</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">USDT
                                Wallet Address
                                (TRC20)</label>
                            <input type="text" name="usdt_wallet_address" value="{{ Auth::user()->usdt_wallet_address }}"
                                placeholder="Enter your TRC20 address"
                                style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;">
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; background: #0095f6; border: none; font-weight: bold; padding: 14px; font-size: 1.1rem;">
                            Update Profile
                        </button>
                    </form>
                </div>

                <div class="post_cart"
                    style="background: #fff; border: 1px solid #ffebee; border-radius: 8px; padding: 25px; margin-top: 25px;">
                    <h4 style="color: #f44336; margin-bottom: 15px; font-size: 1.3rem;">Danger Zone</h4>
                    <p style="font-size: 1rem; color: #8e8e8e; margin-bottom: 20px;">Once you delete your account, there
                        is no going back. Please be certain.</p>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            style="width: 100%; background: #ed4956; border: none; font-weight: bold; padding: 14px; font-size: 1.1rem;">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
