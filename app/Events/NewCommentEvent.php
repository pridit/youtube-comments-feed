<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NewCommentEvent
{
    use SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\Google_Service_YouTube_CommentSnippet $comment)
    {
        $this->comment = $comment;
    }
}
