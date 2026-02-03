@extends('layouts.app')

@section('title', 'Review Submissions')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories" style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb;">
                <h3>Pending Proof Reviews</h3>
                <p>Verify user screenshots and approve rewards.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="admin-content" style="padding: 20px;">
                @forelse($submissions as $submission)
                    <div class="post_cart"
                        style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; margin-bottom: 24px; padding: 20px;">
                        <div style="display: flex; gap: 20px;">
                            <div style="flex: 1;">
                                <h5 style="margin: 0 0 10px 0;">Task:
                                    {{ $submission->task ? $submission->task->title : 'Deleted Task' }}</h5>
                                <p style="margin: 0 0 5px 0;"><strong>User:</strong> {{ $submission->user->name }}
                                    ({{ $submission->user->email }})
                                </p>
                                <p style="margin: 0 0 15px 0;"><strong>Submitted:</strong>
                                    {{ $submission->created_at->diffForHumans() }}</p>

                                <div style="margin-top: 20px; display: flex; gap: 10px;">
                                    <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST"
                                        style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            style="width: 100%; font-weight: bold; background: #47a138; border: none; color: white; padding: 10px;">
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-danger"
                                        style="flex: 1; font-weight: bold; background: #ed4956; border: none; color: white; padding: 10px;"
                                        onclick="toggleReject('{{ $submission->id }}')">
                                        Reject
                                    </button>
                                </div>

                                <form id="reject-form-{{ $submission->id }}"
                                    action="{{ route('admin.submissions.reject', $submission) }}" method="POST"
                                    style="display: none; margin-top: 15px;">
                                    @csrf
                                    <textarea name="feedback" placeholder="Provide reason for rejection" required
                                        style="width: 100%; border: 1px solid #dbdbdb; border-radius: 4px; padding: 10px; margin-bottom: 10px;"></textarea>
                                    <button type="submit" class="btn btn-danger"
                                        style="width: 100%; background: #ed4956; border: none; color: white; padding: 8px;">Submit
                                        Rejection</button>
                                </form>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <a href="{{ Storage::url($submission->proof_image_path) }}" target="_blank">
                                    <img src="{{ Storage::url($submission->proof_image_path) }}" alt="Proof Screenshot"
                                        style="max-width: 100%; border-radius: 4px; border: 1px solid #efefef;">
                                </a>
                                <p style="font-size: 0.8rem; color: #8e8e8e; margin-top: 5px;">Click to view full size</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px;">
                        <p style="color: #8e8e8e;">No pending submissions to review.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function toggleReject(id) {
            const form = document.getElementById('reject-form-' + id);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection
