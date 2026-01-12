<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show admin dashboard with all posts.
     */
    public function index()
    {
        $posts = Post::with('user', 'comments')
            ->latest()
            ->paginate(15);

        return view('admin.index', compact('posts'));
    }
}
