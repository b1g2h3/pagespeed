<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class AppController extends Controller
{
    public function index() {
        return view('app');
    }

    public function pageSpeed(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $data = new ApiClient($request->url);
        return $data->getData();
    }
}

class ApiClient
{

    private $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?'.
                            'strategy=desktop&category=seo&category=performance&category=best-practices&url=';
    private $response;

    private $err;

    public function __construct($siteUrl, $apiKey = 'AIzaSyBgdR1en5CaqEioQsajPTWO1OK_5rO-BCs')
    {
        $url = $this->apiUrl.$siteUrl;
        if (!empty($apiKey)) {
            $url .= '&key='.$apiKey.'&locale=cs';
        }

        $client = new \GuzzleHttp\Client();
        try {
            $res =$client->get($url);
            $response = (string) $res->getBody();
        } catch (RequestException $e) {
            $this->err = json_decode($e->getResponse()->getBody()->getContents(), true);
        }   
        empty($this->err) ? $this->response = json_decode($response) : false;
    }

    public function getData () {
            return array (
                'audits' => $this->getLighthouseResult(),
            );
    }

    public function getLighthouseResult()
    {
        return empty($this->err) ? $this->response->lighthouseResult->audits : false;
        // $this->response->lighthouseResult->audits
    }
}