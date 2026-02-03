@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories"
                style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb; display: flex; align-items: center;">
                <a href="{{ route('admin.tasks.index') }}" style="margin-right: 20px;">
                    <img src="{{ asset('images/menu.png') }}" style="transform: rotate(90deg); width: 24px;">
                </a>
                <h3 style="margin: 0; font-size: 1.5rem;">Create New Task</h3>
            </div>

            <div class="tasks-content" style="padding: 20px;">
                <div class="post_cart"
                    style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 25px;">
                    <form action="{{ route('admin.tasks.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">Task
                                Title</label>
                            <input type="text" name="title" required
                                style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;"
                                placeholder="e.g., Follow @instagram">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">Description</label>
                            <textarea name="description" required rows="4"
                                style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;"
                                placeholder="Details about what the user needs to do..."></textarea>
                        </div>

                        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                            <div style="flex: 1;">
                                <label
                                    style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">Type</label>
                                <select name="type" required
                                    style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;">
                                    <option value="Follow">Follow</option>
                                    <option value="Like">Like</option>
                                    <option value="Comment">Comment</option>
                                    <option value="Share">Share</option>
                                </select>
                            </div>
                            <div style="flex: 1;">
                                <label
                                    style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">Reward
                                    (AED)</label>
                                <input type="number" name="reward_aed" step="0.01" min="0" required
                                    style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;"
                                    placeholder="e.g., 10.00">
                            </div>
                        </div>

                        <div style="margin-bottom: 30px;">
                            <label
                                style="display: block; margin-bottom: 10px; font-weight: bold; font-size: 1rem;">Instagram
                                URL</label>
                            <input type="url" name="instagram_url" required
                                style="width: 100%; padding: 12px; border: 1px solid #dbdbdb; border-radius: 4px; font-size: 1rem;"
                                placeholder="https://instagram.com/...">
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; background: #0095f6; border: none; font-weight: bold; padding: 15px; font-size: 1.2rem; border-radius: 4px;">
                            Create Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
