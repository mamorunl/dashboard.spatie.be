<?php
/**
 * Created by Bas Hepping <info@mamoru.nl>.
 * Date: 12-4-2017
 * Time: 20:39
 */

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NestController extends Controller
{
    public function index()
    {
        return redirect('https://home.nest.com/login/oauth2?client_id=0b3f6fb2-9e43-4633-978c-dba7ef454fb7&state=STATE');

//        if(!Session::has('nest_access_token')) {
//            $result = $client->request('POST', 'https://api.home.nest.com/oauth2/access_token', [
//                'form_params' => [
//                    'code'          => '2SG7BUJ4',
//                    'client_id'     => '0b3f6fb2-9e43-4633-978c-dba7ef454fb7',
//                    'client_secret' => 'Zjkpk9pwGB75ojcoXPo00Mcqy',
//                    'grant_type'    => 'authorization_code'
//                ]
//            ]);
//
//            $access_token = json_decode($result->getBody()
//                ->getContents())->access_token;
//
//            Session::set('nest_access_token', $access_token);
//        }
//
//        $access_token = Session::get('nest_access_token');
//
//        $response = $client->request('GET', 'https://developer-api.nest.com/', [
//            'headers' => [
//                'Content-Type'  => 'text/event-stream',
//                'Authorization' => 'Bearer ' . $access_token
//            ]
//        ]);
//
//        dd(json_decode($response->getBody()->getContents()));
    }
    
    public function authorizeApp(Request $request)
    {
        $client = new Client();
        $result = $client->request('POST', 'https://api.home.nest.com/oauth2/access_token', [
            'form_params' => [
                'code'          => 'GRACA538',//$request->get('code'),
                'client_id'     => '0b3f6fb2-9e43-4633-978c-dba7ef454fb7',
                'client_secret' => 'Zjkpk9pwGB75ojcoXPo00Mcqy',
                'grant_type'    => 'authorization_code'
            ]
        ]);
    
        $access_token = json_decode($result->getBody()
            ->getContents())->access_token;
    
        file_put_contents(storage_path() . '/app/nest_session_token', $access_token);
    }
    
    public function getTemperature()
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
//        $client = new Client;
//        $access_token = file_get_contents(storage_path() . '/app/nest_session_token');
//
//        try {
//            $response = $client->request('GET', 'https://developer-api.nest.com/', [
//                'headers' => [
//                    'Content-Type'  => 'text/event-stream',
//                    'Authorization' => 'Bearer ' . $access_token
//                ]
//            ]);
//
//            dd(json_decode($response->getBody()
//                ->getContents()));
//        } catch (ClientException $e) {
//            echo "<h1>ERROR ";
//            echo $e->getCode();
//            echo "</h1><pre>";
//            echo $e->getMessage();
//            echo $access_token;
//            echo "</pre>";
//            echo $e->getResponse()
//                ->getBody()
//                ->getContents();
//        }
        
        $data = file_get_contents(storage_path() . '/app/nest_session_info');
        
        dd($data);
    }
}