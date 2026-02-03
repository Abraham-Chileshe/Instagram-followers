@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="main_section">
        <div class="posts_container" style="max-width: 700px; width: 100%;">
            <div class="stories" style="height: auto; padding: 20px;">
                <h3>Welcome, {{ Auth::user()->name }}</h3>
                <p>Your Instagram growth starts here.</p>
                <form action="{{ route('invite.generate') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="btn btn-primary"
                        style="background: #0095f6; border: none; font-weight: bold; font-size: 0.9rem;">Generate Invite
                        Code</button>
                </form>
            </div>

            <div class="dashboard-content">
                <div class="post_cart"
                    style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dbdbdb; margin-bottom: 25px;">
                    <h4 style="font-size: 1.2rem; margin-bottom: 20px;">Balance Statistics</h4>
                    <div style="display: flex; justify-content: space-around; margin-top: 10px;">
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-size: 2rem; font-weight: bold; color: #262626;">{{ Auth::user()->balance_aed }}
                                AED</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Current Balance</span>
                        </div>
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-size: 2rem; font-weight: bold; color: #262626;">{{ Auth::user()->referrals()->count() }}</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Referrals</span>
                        </div>
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-size: 2rem; font-weight: bold; color: #262626;">{{ Auth::user()->submissions()->where('status', 'approved')->count() }}</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Tasks Completed</span>
                        </div>
                    </div>
                </div>

                <div class="post_cart"
                    style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dbdbdb; margin-bottom: 25px;">
                    <h4 style="font-size: 1.2rem; margin-bottom: 10px;">Available Tasks</h4>
                    <p style="font-size: 1rem; margin-bottom: 20px;">Complete tasks to earn rewards.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-primary"
                        style="background: #0095f6; border: none; font-weight: bold; font-size: 1.1rem; padding: 10px 20px;">View
                        All Tasks</a>
                </div>

                <div class="post_cart"
                    style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dbdbdb;">
                    <h4 style="font-size: 1.2rem; margin-bottom: 15px;">Recent Activity</h4>
                    <ul style="list-style: none; padding: 0; margin-top: 10px;">
                        @forelse(Auth::user()->submissions()->latest()->take(3)->get() as $submission)
                            <li style="border-bottom: 1px solid #efefef; padding: 15px 0;">
                                <span style="display: block; font-weight: bold; font-size: 1.1rem;">Submitted:
                                    {{ $submission->task ? $submission->task->title : 'Deleted Task' }}</span>
                                <span
                                    style="font-size: 0.95rem; color: #8e8e8e;">{{ $submission->created_at->diffForHumans() }}
                                    -
                                    <span
                                        style="font-weight: bold; color: {{ $submission->status == 'approved' ? '#4caf50' : ($submission->status == 'rejected' ? '#f44336' : '#fbc02d') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </span>
                            </li>
                        @empty
                            <li style="padding: 15px 0; color: #8e8e8e; font-size: 1rem;">No recent activity.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="followers_container">
        <div>
            <div class="cart">
                <div>
                    <div class="img">
                        <img src="{{ asset('images/profile_img.jpg') }}" alt="">
                    </div>
                    <div class="info">
                        <p class="name">{{ Auth::user()->username ?? 'User' }}</p>
                        <p class="second_name">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
            <div class="suggestions">
                <div class="title">
                    <h4>Recent Referrals</h4>
                    <a class="dark" href="{{ route('referrals.index') }}">See All</a>
                </div>
                @forelse(Auth::user()->referrals()->latest()->take(5)->get() as $referral)
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="{{ asset('images/profile_img.jpg') }}" alt="">
                            </div>
                            <div class="info">
                                <p class="name">{{ $referral->name }}</p>
                                <p class="second_name">Joined {{ $referral->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="padding: 10px; color: #8e8e8e;">No referrals yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
