<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'image_path',
        'video_path',
    ];

    /**
     * Generate slug from title automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /**
     * Get the user that owns the post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes for the post
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the post is liked by a specific user
     */
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the boards this post belongs to
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class);
    }

    /**
     * Get the route key for the model (use slug instead of id)
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
