<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'author', 'text', 'video', 'parent', 'published_at'
    ];

    /**
     * Determine whether the comment matches an existing record based on
     * the author, comment, & when it was published
     *
     * @var $query
     * @var $comment
     */
    public function scopeMatches($query, $comment)
    {
        return $query->where('author', $comment->authorDisplayName)
            ->where('text', $comment->textOriginal)
            ->where('published_at', $comment->publishedAt);
    }
}
