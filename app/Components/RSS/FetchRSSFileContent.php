<?php

namespace App\Components\RSS;

use App\Components\Trello\Events\FileContentFetched;
use Illuminate\Console\Command;

class FetchTrelloFileContent extends Command
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
        $trello = "";
        $cards = \Gregoriohc\LaravelTrello\Facades\Wrapper::boards()->cards()->all(env('TRELLO_BOARD_ID'), []);
        
        foreach ($cards as $card) {
            $list = \Gregoriohc\LaravelTrello\Facades\Wrapper::lists()->show($card['idList']);
        
            $trello .= "[" . $list['name'] . "] " . $card['name'] . "<br>";
        }

        event(new FileContentFetched($trello));
    }
}
