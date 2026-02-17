@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="main_section">
        <div class="posts_container" style="max-width: 700px; width: 100%;">
            <div class="stories"
                style="height: auto; padding: 20px; display: flex; align-items: center; overflow-x: auto; gap: 15px; border-bottom: 1px solid #dbdbdb;">
                <!-- Upload Story Button -->
                <div style="flex-shrink: 0; text-align: center;">
                    <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data"
                        id="story-upload-form">
                        @csrf
                        <label for="story_file" style="cursor: pointer;">
                            <div
                                style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #0095f6; display: flex; align-items: center; justify-content: center; background: #fff;">
                                <span style="font-size: 2rem; color: #0095f6;">+</span>
                            </div>
                            <span style="font-size: 0.8rem; display: block; margin-top: 5px;">Your Story</span>
                        </label>
                        <input type="file" name="story_file" id="story_file" style="display: none;"
                            onchange="document.getElementById('story-upload-form').submit();">
                    </form>
                </div>

                <!-- Active Stories -->
                @foreach ($stories as $story)
                    <div style="flex-shrink: 0; text-align: center; cursor: pointer;"
                        onclick="viewStory('{{ asset('storage/' . $story->file_path) }}', '{{ $story->type }}')">
                        <div
                            style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #e1306c; padding: 2px;">
                            <img src="{{ $story->type == 'image' ? asset('storage/' . $story->file_path) : asset('images/profile_img.jpg') }}"
                                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        </div>
                        <span
                            style="font-size: 0.8rem; display: block; margin-top: 5px; width: 60px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ optional($story->user)->name ?? 'User' }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Story Viewer Modal (Simple) -->
            <div id="story-viewer"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;">
                <span onclick="closeStory()"
                    style="position: absolute; top: 20px; right: 30px; color: #fff; font-size: 2rem; cursor: pointer;">&times;</span>
                <div id="story-content" style="max-width: 90%; max-height: 90%;"></div>
            </div>

            <script>
                function viewStory(url, type) {
                    const viewer = document.getElementById('story-viewer');
                    const content = document.getElementById('story-content');
                    content.innerHTML = '';
                    if (type === 'image') {
                        content.innerHTML = `<img src="${url}" style="max-width: 100%; max-height: 80vh; border-radius: 8px;">`;
                    } else {
                        content.innerHTML =
                            `<video src="${url}" controls autoplay style="max-width: 100%; max-height: 80vh; border-radius: 8px;"></video>`;
                    }
                    viewer.style.display = 'flex';
                }

                function closeStory() {
                    document.getElementById('story-viewer').style.display = 'none';
                    document.getElementById('story-content').innerHTML = '';
                }
            </script>

            <div class="dashboard-content">
                <div class="post_cart"
                    style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dbdbdb; margin-bottom: 25px;">
                    <h4 style="font-size: 1.2rem; margin-bottom: 20px;">Balance Statistics</h4>
                    <div style="display: flex; justify-content: space-around; margin-top: 10px;">
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-size: 2rem; font-weight: bold; color: #262626;">{{ Auth::user()?->balance_aed ?? 0 }}
                                AED</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Current Balance</span>
                        </div>
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-size: 2rem; font-weight: bold; color: #262626;">{{ Auth::user()?->referrals()->count() ?? 0 }}</span>
                            <span style="font-size: 1rem; color: #8e8e8e;">Referrals</span>
                        </div>
                        <div style="text-align: center;">
                            <span
                                style="display: block; font-size: 2rem; font-weight: bold; color: #262626;">{{ Auth::user()?->submissions()->where('status', 'approved')->count() ?? 0 }}</span>
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
                        @forelse(optional(Auth::user())->submissions()?->latest()->take(3)->get() ?? [] as $submission)
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
                        <p class="name">{{ Auth::user()?->username ?? 'User' }}</p>
                        <p class="second_name">{{ Auth::user()?->name ?? 'Anonymous' }}</p>
                    </div>
                </div>
            </div>
            <div class="suggestions">
                <div class="title">
                    <h4>Recent Referrals</h4>
                    <a class="dark" href="{{ route('referrals.index') }}">See All</a>
                </div>
                @forelse(optional(Auth::user())->referrals()?->latest()->take(5)->get() ?? [] as $referral)
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
