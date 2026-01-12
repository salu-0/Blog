<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * Get the user that owns the board
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the posts for the board
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
