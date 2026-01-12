<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user', 'comments')
            ->latest()
            ->paginate(20); // Increased pagination for feed

        if (Auth::check()) {
            return view('posts.feed', compact('posts'));
        }

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Show the form for creating a new pin.
     */
    public function createPin()
    {
        return view('posts.create-pin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,webm,m4v|max:204800', // 200MB max
        ]);

        $data = [
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'slug' => Str::slug($request->title),
        ];

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mimeType = $file->getMimeType();
            $path = $file->store('posts', 'public');

            if (str_starts_with($mimeType, 'image/')) {
                $data['image_path'] = $path;
            } elseif (str_starts_with($mimeType, 'video/')) {
                $data['video_path'] = $path;
            }
        }

        Post::create($data);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource (using slug).
     */
    public function show(Post $post)
    {
        $post->load('user', 'comments.user');
        $post->loadCount('likes');

        // Fetch related posts for "More like this" section
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(12)
            ->get();

        $userBoards = Auth::check() ? Auth::user()->boards : collect();
        $isLiked = Auth::check() ? $post->isLikedBy(Auth::user()) : false;

        return view('posts.show', compact('post', 'relatedPosts', 'userBoards', 'isLiked'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Only allow post owner to edit
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Only allow post owner to update
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Update slug if title changed
        if ($post->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);

            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Post::where('slug', $validated['slug'])->where('id', '!=', $post->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Only allow post owner to delete
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}
