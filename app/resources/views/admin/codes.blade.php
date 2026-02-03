@extends('layouts.app')

@section('title', 'Admin - Access Codes')

@section('content')
    <div class="main_section" style="width: 100%; max-width: 700px; margin: 0 auto;">
        <div class="posts_container" style="max-width: 100%; width: 100%;">
            <div class="stories"
                style="height: auto; padding: 20px; border-bottom: 1px solid #dbdbdb; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0;">Access Code Management</h3>
                    <p style="margin: 5px 0 0 0;">Generate and track single-use entry codes.</p>
                </div>
                <form action="{{ route('admin.codes.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary"
                        style="background: #0095f6; border: none; font-weight: bold; padding: 10px 20px;">
                        Generate New Code
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="margin: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="admin-content" style="padding: 20px;">
                <div class="post_cart" style="background: #fff; border: 1px solid #dbdbdb; border-radius: 8px; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #dbdbdb; background: #fafafa;">
                                <th style="padding: 15px; text-align: left;">Code</th>
                                <th style="padding: 15px; text-align: left;">Status</th>
                                <th style="padding: 15px; text-align: left;">Used By</th>
                                <th style="padding: 15px; text-align: left;">Expires</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($codes as $code)
                                <tr style="border-bottom: 1px solid #dbdbdb;">
                                    <td
                                        style="padding: 15px; font-weight: bold; font-family: monospace; font-size: 1.1rem;">
                                        {{ $code->code }}</td>
                                    <td style="padding: 15px;">
                                        <span class="badge"
                                            style="
                                        padding: 4px 10px; 
                                        border-radius: 4px; 
                                        font-size: 0.75rem; 
                                        font-weight: bold;
                                        @if ($code->status == 'active') background: #e3f2fd; color: #1976d2; 
                                        @else background: #eeeeee; color: #757575; @endif
                                    ">
                                            {{ ucfirst($code->status) }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px;">
                                        @if ($code->user)
                                            <span style="font-size: 0.9rem;">{{ $code->user->name }}</span>
                                        @else
                                            <span style="color: #8e8e8e; font-size: 0.9rem;">Unused</span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px; font-size: 0.85rem; color: #8e8e8e;">
                                        {{ $code->expires_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding: 40px; text-align: center; color: #8e8e8e;">No access
                                        codes generated yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
