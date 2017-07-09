<?php

namespace App\Console;

use App\Components\Nest\ReloadNestStatus;
use App\Components\RSS\FetchRSSFileContent;
use App\Components\Wunderground\FetchLocalWeather;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Components\GitHub\FetchGitHubFileContent::class,
        \App\Components\Trello\FetchTrelloFileContent::class,
        \App\Components\GoogleCalendar\FetchGoogleCalendarEvents::class,
        \App\Components\LastFm\FetchCurrentTrack::class,
        \App\Components\Packagist\FetchTotals::class,
        \App\Components\InternetConnectionStatus\SendHeartbeat::class,
        \App\Components\RainForecast\FetchRainForecast::class,
        FetchRSSFileContent::class,
        ReloadNestStatus::class,
        FetchLocalWeather::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('dashboard:lastfm')->everyMinute();
        $schedule->command('dashboard:heartbeat')->everyMinute();
        $schedule->command('dashboard:rain')->everyMinute();
        
        $schedule->command('dashboard:github')->everyFiveMinutes();
        
        $schedule->command('dashboard:nest')->everyTenMinutes();
        
        $schedule->command('dashboard:trello')->everyThirtyMinutes();
        $schedule->command('dashboard:rss')->everyThirtyMinutes();
        
        $schedule->command('dashboard:calendar')->hourly();
        $schedule->command('dashboard:packagist')->hourly();
        $schedule->command('dashboard:wunderground')->hourly();
    }
}
