<?php

namespace App\Console\Commands;

use App\Comment;
use App\Traits\ChainsTrait;
use App\Events\NewCommentEvent as NewComment;

use Illuminate\Console\Command;

class PollYoutubeCommand extends Command
{
    use ChainsTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "poll:youtube";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Poll the YouTube API for new comments";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getChainFormatted(config('app.comments'))
            ->filter(function ($comment) {
                return !Comment::matches($comment)->count();
            })
            ->each(function ($comment) {
                event(new NewComment($comment));
            });
    }
}
