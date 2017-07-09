<?php

namespace App\Components\RSS;

use App\Components\RefreshRSSEvent;
use App\Components\RSS\Events\FileContentFetched;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use willvincent\Feeds\Facades\FeedsFacade;

class FetchRSSFileContent extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch RSS feed content.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $feed = FeedsFacade::make('http://feeds.nos.nl/nosnieuwsalgemeen');
        
        $rss_items = collect($feed->get_items())
            ->map(function($item) {
                return [
                    'title' => $item->get_title(),
                    'intro' => Str::words(strip_tags($item->get_description()), 35)
                ];
            })
            ->toArray();

        event(new FileContentFetched(array_slice($rss_items, 0, 5)));
        event(new RefreshRSSEvent());
    }
}
