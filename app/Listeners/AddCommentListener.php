<?php

namespace App\Listeners;

use App\Comment;
use App\Events\NewCommentEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewCommentEvent  $event
     * @return void
     */
    public function handle(NewCommentEvent $event)
    {
        $comment = Comment::firstOrNew(['published_at' => $event->comment->publishedAt], [
            'avatar'        => $event->comment->authorProfileImageUrl,
            'author'        => $event->comment->authorDisplayName,
            'text'          => $event->comment->textOriginal,
            'video'         => $event->comment->videoId,
            'parent'        => $event->comment->parentId,
            'published_at'  => $event->comment->publishedAt
        ]);

        $comment->save();
    }
}
