@extends('layouts.app')

@section('title', 'Available Tasks')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories" style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb;">
                <h3 style="font-size: 1.5rem;">Available Tasks</h3>
                <p style="font-size: 1rem;">Earn AED by completing these Instagram engagement tasks.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="tasks-content">
                @forelse($tasks as $task)
                    <div class="post_cart"
                        style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; margin-bottom: 25px; padding: 25px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="margin: 0; font-size: 1.3rem;">{{ $task->title }}</h4>
                            <span class="badge"
                                style="background: #efefef; color: #262626; padding: 8px 15px; border-radius: 4px; font-weight: bold; font-size: 1rem;">
                                {{ $task->reward_aed }} AED
                            </span>
                        </div>
                        <p style="color: #8e8e8e; margin-bottom: 20px; font-size: 1rem;">
                            {{ Str::limit($task->description, 100) }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #0095f6; font-size: 1rem; text-transform: uppercase; font-weight: bold;">
                                Type: {{ $task->type }}
                            </span>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-primary"
                                style="background: #0095f6; border: none; font-weight: bold; padding: 10px 20px; font-size: 1rem;">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px;">
                        <p style="color: #8e8e8e; font-size: 1rem;">No tasks available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
