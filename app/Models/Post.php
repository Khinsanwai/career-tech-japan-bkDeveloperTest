<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author_id',
    ];

    /**
     * Get the likes for the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class); // Assuming you have a Like model
    }

    /**
     * Get the tags for the post.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class); // Assuming a many-to-many relationship with Tag
    }
}

