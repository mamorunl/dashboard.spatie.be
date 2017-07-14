<?php

namespace App\Components\Wunderground;

use App\Components\Wunderground\Events\DataFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FetchLocalWeather extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:wunderground';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Wunderground feed content.';
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $json = file_get_contents("http://api.wunderground.com/api/3236938b09d08580/hourly/q/Netherlands/Bedum.json");
        file_put_contents("wunderground_original", $json);
//        $json = file_get_contents("wunderground_original");
        
        $weather = json_decode($json);
        
        $hour_array = [];
        
        $variables = [
            'max_temp' => -99999,
            'max_rain' => -99999,
            'max_snow' => -99999
        ];
        
        $carbon_now = Carbon::now();
        
        foreach ($weather->hourly_forecast as $hour) {
            if ($hour->temp->metric > $variables['max_temp'] && $hour->FCTTIME->mday == $carbon_now->day) {
                $variables['max_temp'] = $hour->temp->metric;
            }
            
            if ($hour->pop > $variables['max_rain'] && $hour->FCTTIME->mday == $carbon_now->day) {
                $variables['max_rain'] = $hour->pop;
            }
            
            if ($hour->snow->metric > $variables['max_snow'] && $hour->FCTTIME->mday == $carbon_now->day) {
                $variables['max_snow'] = $hour->snow->metric;
            }
            
            $hour_array[$hour->FCTTIME->mday][$hour->FCTTIME->hour] = [
                'hour'        => $hour->FCTTIME->hour,
                'temperature' => ($hour->temp->metric ?? 0),
                'feelslike'   => ($hour->feelslike->metric ?? 0),
                'dewpoint'    => $hour->dewpoint,
                'condition'   => $hour->condition,
                'icon'        => $hour->icon_url,
                'wind'        => [
                    'speed'           => ($hour->wspd->metric ?? 0),
                    'direction'       => $hour->wdir->dir,
                    'direction_angle' => $hour->wdir->degrees
                ],
                'humidity'    => $hour->humidity,
                'snow'        => ($hour->snow->metric ?? 0),
                'rain'        => ($hour->pop ?? 0),
                'day'         => $hour->FCTTIME->mday,
                'cur_day'     => $carbon_now->day
            ];
        }
        
        $data_9 = $carbon_now->hour >= 9 ? $hour_array[$carbon_now->day + 1][9] : $hour_array[$carbon_now->day][9];
        $data_17 = $carbon_now->hour >= 17 ? $hour_array[$carbon_now->day + 1][17] : $hour_array[$carbon_now->day][17];
        
        $data = [
            'max_temp' => $variables['max_temp'],
            'max_rain' => $variables['max_rain'],
            'max_snow' => $variables['max_snow'],
            'data_9'   => $data_9,
            'data_17'  => $data_17
        ];
//        dd($data);
        
        event(new DataFetched($data));
    }
}
