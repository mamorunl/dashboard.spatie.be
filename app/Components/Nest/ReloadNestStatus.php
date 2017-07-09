<?php

namespace App\Components\Nest;

use App\Components\Nest\Events\ReadNest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;

class ReloadNestStatus extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:nest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload Nest.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client;
        
        $access_token = file_get_contents(storage_path() . '/app/nest_session_token');
    
        try {
            $response = $client->request('GET', 'https://developer-api.nest.com/devices/thermostats?auth=' . $access_token, [
//                'headers' => [
//                    'Content-Type'  => 'application/json',
//                    'Authorization' => 'Bearer ' . $access_token
//                ]
            ]);
        
            $response_data = $response->getBody()
                ->getContents();
        
            file_put_contents(storage_path() . '/app/nest_session_info', $response_data);
        
            //return redirect('/nest/temperature');
        } catch (ClientException $e) {
            echo "<h1>ERROR ";
            echo $e->getCode();
            echo "</h1><pre>";
            echo $e->getMessage();
            echo $access_token;
            echo "</pre>";
            echo $e->getResponse()
                ->getBody()
                ->getContents();
        }
        
        event(new ReadNest);
    }
}
