<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class WeatherController extends Controller
{
    protected $link = 'https://api.weather.yandex.ru/v2/forecast?lat=53.287498&lon=34.380562';

    public function index()
    {
        $apiKey = env('WEATHER_API_KEY');
        $townId = '571476';
        $url = 'api.openweathermap.org/data/2.5/forecast?id=' . $townId . '&lang=ru&units=metric&appid=' . $apiKey;

        $client = new Client();
        $res = $client->request('GET', $url);
        $data = json_decode($res->getBody());
        $currentTime = date('d F Y');
        return view('weather', ['data' => $data, 'time' => $currentTime]);

    }

    public function weatherYandexGuzzle()
    {
        $key = env('WEATHER_API_KEY_YANDEX');
        $client = new Client();
        $res = $client->request('GET', $this->link, [
            'headers' => [
                'X-Yandex-API-Key' => $key,
            ]
        ]);
        $res = json_decode($res->getBody());
        if ($res){
            return$this->getDataForRender($res);
        }
        return redirect()->back();

    }


    public function weatherYandexCurl()
    {
        $key = env('WEATHER_API_KEY_YANDEX');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Yandex-API-Key: $key"]);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($ch);
        $res = (json_decode($output));
        if($res){
            return $this->getDataForRender($res);
        }
        return redirect()->back();
    }



    protected function getDataForRender($dataObject)
    {
        $town = $dataObject->geo_object->locality->name;
        $data = 'Погода ' . $town . ' ' . $dataObject->fact->temp. ' C';
        return view('empty', ['data' => $data]);
    }
    // TODO if no data index && -> to Service
}
