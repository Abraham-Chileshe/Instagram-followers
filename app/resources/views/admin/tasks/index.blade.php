@extends('layouts.app')

@section('title', 'Manage Tasks')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories"
                style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.5rem;">Manage Tasks</h3>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary"
                    style="background: #0095f6; border: none; font-weight: bold; font-size: 1rem; padding: 10px 20px;">
                    Add New Task
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="tasks-content" style="padding: 20px;">
                @forelse($tasks as $task)
                    <div class="post_cart"
                        style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; margin-bottom: 25px; padding: 25px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h4 style="margin: 0 0 5px 0; font-size: 1.3rem;">{{ $task->title }}</h4>
                            <p style="color: #8e8e8e; margin: 0; font-size: 1rem;">
                                {{ $task->reward_aed }} AED • {{ $task->type }}
                            </p>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary"
                                style="border: 1px solid #dbdbdb; color: #262626; font-weight: bold; padding: 8px 15px; text-decoration: none; border-radius: 4px;">
                                View
                            </a>
                            <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    style="background: #ed4956; border: none; font-weight: bold; padding: 8px 15px; color: white; border-radius: 4px;">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px;">
                        <p style="color: #8e8e8e; font-size: 1rem;">No tasks found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
