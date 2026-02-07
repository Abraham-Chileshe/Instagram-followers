<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'story_file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:20480', // 20MB max
        ]);

        $file = $request->file('story_file');
        $path = $file->store('stories', 'public');
        $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';

        Story::create([
            'user_id' => Auth::id(),
            'file_path' => $path,
            'type' => $type,
            'expires_at' => now()->addHours(24),
        ]);

        return back()->with('success', 'Story uploaded successfully!');
    }
}
