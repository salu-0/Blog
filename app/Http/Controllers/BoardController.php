<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Auth::user()->boards()->create([
            'name' => $request->name,
        ]);

        return response()->json($board);
    }

    public function savePost(Request $request, Post $post)
    {
        $request->validate([
            'board_id' => 'required|exists:boards,id',
        ]);

        $board = Auth::user()->boards()->findOrFail($request->board_id);

        // Attach post to board if not already attached
        if (!$board->posts()->where('post_id', $post->id)->exists()) {
            $board->posts()->attach($post->id);
        }

        return response()->json(['message' => 'Saved to ' . $board->name]);
    }

    public function downloadLink(Post $post)
    {
        if ($post->image_path) {
            return response()->download(storage_path('app/public/' . $post->image_path));
        } elseif ($post->video_path) {
            return response()->download(storage_path('app/public/' . $post->video_path));
        }

        return abort(404);
    }
}
