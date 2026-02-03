@extends('layouts.app')

@section('title', 'Referral Dashboard')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories" style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb;">
                <h3 style="font-size: 1.5rem;">Referral Program</h3>
                <p style="font-size: 1rem;">Earn 50% of the rewards from every task your referrals complete.</p>
            </div>

            <div class="referral-content" style="padding: 20px;">
                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px; margin-bottom: 25px;">
                    <h4 style="margin-bottom: 20px; font-size: 1.3rem;">Your Referral Link</h4>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" value="{{ url('/access-code') }}?ref={{ Auth::id() }}" id="referral-link"
                            readonly
                            style="flex: 1; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; background: #fafafa; color: #8e8e8e; font-size: 1rem;">
                        <button onclick="copyToClipboard()" class="btn btn-primary"
                            style="background: #0095f6; border: none; font-weight: bold; padding: 0 25px; font-size: 1rem;">Copy</button>
                    </div>
                    <p id="copy-success" style="color: #4caf50; font-size: 1rem; margin-top: 10px; display: none;">Link
                        copied to clipboard!</p>
                </div>

                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px; margin-bottom: 25px;">
                    <h4 style="font-size: 1.3rem;">Earnings Summary</h4>
                    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                        <div>
                            <span
                                style="display: block; font-size: 1.8rem; font-weight: bold;">{{ Auth::user()->referrals()->count() }}</span>
                            <span style="color: #8e8e8e; font-size: 1rem;">Total Referrals</span>
                        </div>
                        <div>
                            <span
                                style="display: block; font-size: 1.8rem; font-weight: bold; color: #0095f6;">{{ Auth::user()->referrals->sum('balance_aed') * 0.5 }}
                                AED</span>
                            <span style="color: #8e8e8e; font-size: 1rem;">Total Referral Income</span>
                        </div>
                    </div>
                </div>

                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px;">
                    <h4 style="margin-bottom: 20px; font-size: 1.3rem;">Your Recruits</h4>
                    <div class="referral-list">
                        @forelse($referrals as $referral)
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #efefef;">
                                <div style="display: flex; align-items: center;">
                                    <img src="{{ asset('images/profile_img.jpg') }}" class="circle"
                                        style="width: 50px; height: 50px; margin-right: 20px;">
                                    <div>
                                        <p style="margin: 0; font-weight: bold; font-size: 1.1rem;">{{ $referral->name }}
                                        </p>
                                        <span style="color: #8e8e8e; font-size: 0.9rem;">Joined
                                            {{ $referral->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span
                                        style="display: block; font-weight: bold; font-size: 1rem;">{{ $referral->submissions()->where('status', 'approved')->count() }}
                                        Tasks</span>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 40px;">
                                <p style="color: #8e8e8e; font-size: 1rem;">You haven't recruited anyone yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("referral-link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            navigator.clipboard.writeText(copyText.value);

            var successMsg = document.getElementById("copy-success");
            successMsg.style.display = "block";
            setTimeout(function() {
                successMsg.style.display = "none";
            }, 3000);
        }
    </script>
@endsection
