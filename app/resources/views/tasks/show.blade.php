@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories"
                style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb; display: flex; align-items: center;">
                <a href="{{ route('tasks.index') }}" style="margin-right: 20px;">
                    <img src="{{ asset('images/menu.png') }}" style="transform: rotate(90deg); width: 24px;">
                </a>
                <h3 style="margin: 0; font-size: 1.5rem;">Task Details</h3>
            </div>

            <div class="tasks-content" style="padding: 20px;">
                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                        <h2 style="margin: 0; font-size: 1.8rem;">{{ $task->title }}</h2>
                        <span
                            style="font-size: 1.5rem; font-weight: bold; color: #262626; background: #efefef; padding: 5px 15px; border-radius: 5px;">{{ $task->reward_aed }}
                            AED</span>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h5 style="color: #262626; margin-bottom: 15px; font-size: 1.3rem;">Description</h5>
                        <p style="color: #3e3e3e; line-height: 1.6; font-size: 1.1rem;">{{ $task->description }}</p>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h5 style="color: #262626; margin-bottom: 15px; font-size: 1.3rem;">Instructions</h5>
                        <ol style="color: #3e3e3e; padding-left: 20px; font-size: 1.1rem; line-height: 1.6;">
                            <li>Click the Instagram button below.</li>
                            <li>Complete the action ({{ $task->type }}).</li>
                            <li>Take a screenshot as proof.</li>
                            <li>Upload the screenshot using the form below.</li>
                        </ol>
                    </div>

                    <div style="text-align: center; margin-bottom: 40px;">
                        <a href="{{ $task->instagram_url }}" target="_blank" class="btn btn-outline-primary"
                            style="border: 2px solid #0095f6; color: #0095f6; font-weight: bold; padding: 12px 40px; border-radius: 5px; text-decoration: none; font-size: 1.1rem;">
                            Open Instagram
                        </a>
                    </div>

                    <hr style="border-top: 1px solid #dbdbdb; margin: 30px 0;">

                    <div>
                        <h5 style="color: #262626; margin-bottom: 20px; font-size: 1.3rem;">Submit Proof</h5>
                        <form action="{{ route('tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="margin-bottom: 25px;">
                                <label for="proof_image"
                                    style="display: block; margin-bottom: 10px; color: #8e8e8e; font-size: 1rem;">Upload
                                    Screenshot (Max 5MB)</label>
                                <input type="file" id="proof_image" name="proof_image" accept="image/*" required
                                    style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;">
                            </div>
                            <button type="submit" class="btn btn-primary"
                                style="width: 100%; background: #0095f6; border: none; font-weight: bold; padding: 15px; font-size: 1.2rem;">
                                Submit for Verification
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
