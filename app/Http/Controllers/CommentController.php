<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
        ]);

        // If user is authenticated, use their info
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        } else {
            // For guest comments, require name and email
            $request->validate([
                'author_name' => 'required|string|max:255',
                'author_email' => 'required|email|max:255',
            ]);
            $validated['author_name'] = $request->author_name;
            $validated['author_email'] = $request->author_email;
        }

        $validated['post_id'] = $post->id;

        Comment::create($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment added successfully!');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        $post = $comment->post;
        
        // Only allow comment owner or post owner to delete
        if ($comment->user_id !== auth()->id() && $comment->post->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment deleted successfully!');
    }
}
