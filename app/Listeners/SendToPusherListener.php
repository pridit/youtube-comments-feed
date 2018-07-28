<?php

namespace App\Listeners;

use App\Events\NewCommentEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendToPusherListener
{
    protected $options;
    protected $pusher;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->options = array(
            'cluster' => 'eu',
            'encrypted' => true
        );

        $this->pusher = new \Pusher\Pusher(
            config('api.pusher.key'),
            config('api.pusher.secret'),
            config('api.pusher.app_id'),
            $this->options
        );
    }

    /**
     * Handle the event.
     *
     * @param  NewCommentEvent  $event
     * @return void
     */
    public function handle(NewCommentEvent $event)
    {
        $this->pusher->trigger('my-channel', 'my-event', $event->comment);
    }
}
