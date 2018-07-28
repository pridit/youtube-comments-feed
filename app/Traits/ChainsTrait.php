<?php

namespace App\Traits;

trait ChainsTrait
{
    protected function getChain($type)
    {
        return collect(config('app.videos.'.config('app.comments')))->map(function ($video) use ($type) {
            return app('youtube')->commentThreads->listCommentThreads(
                $type,
                ['videoId' => $video]
            );
        });
    }

    public function getChainFormatted($type)
    {
        switch($type) {
            case 'snippet':
                $chain = $this->getChain($type)->pluck('items')
                    ->flatten()
                    ->pluck(['snippet', 'topLevelComment'])
                    ->flatten()
                    ->pluck('snippet');
                break;

            case 'replies':
                $chain = $this->getChain($type)->pluck('items')
                    ->flatten()
                    ->pluck(['replies', 'comments'])
                    ->flatten()
                    ->pluck('snippet')
                    ->reject(function ($comment) {
                        return (
                            collect(config('app.ignore'))->contains($comment['authorDisplayName']) ||
                            is_null($comment) ||
                            ($comment['authorDisplayName'] == 'TheMegaUzumaki' && strpos($comment['textOriginal'], 'Pridit') !== false)
                        );
                    });
                break;
        }

        return $chain->sortBy('publishedAt');
    }
}
