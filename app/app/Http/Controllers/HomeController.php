<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stories = Story::with('user')
            ->where('expires_at', '>', now())
            ->latest()
            ->get();
            
        return view('home', compact('stories'));
    }
}
