<?php

namespace App\Services;

use GuzzleHttp\Client;

class CameraService
{
    protected $uri = 'http://127.0.0.1:4000';

    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->uri]);
    }

    protected function post($uri, $data = [])
    {
        $data['secret'] = 'rmkQ1XRMmFGYyuG7Oeicf1fYmTnqV2h8XJctTUCxaLQ=';

        $res = $this->client->request('POST', $uri, [
            'json' => $data
        ]);

        return json_decode($res->getBody()->read(1024), true);
    }

    public function create($data = [])
    {
        return $this->post('/api/rtsp/create', $data);
    }

    public function update($key, $data = [])
    {
        return $this->post('/api/rtsp/update/' . $key, $data);
    }

    public function delete($key)
    {
        return $this->post('/api/rtsp/delete/' . $key);
    }
}