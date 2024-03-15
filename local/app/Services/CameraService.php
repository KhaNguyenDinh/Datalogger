<?php

namespace App\Services;

use GuzzleHttp\Client;

class CameraService
{
    protected $uri = 'https://live.cae.vn';

    protected $client;

    public function __construct()
    {
        $this->uri = config('app.camera_url');
        $this->client = new Client(['base_uri' => $this->uri]);
    }

    protected function post($uri, $data = [])
    {
        $data['secret'] = 'rmkQ1XRMmFGYyuG7Oeicf1fYmTnqV2h8XJctTUCxaLQ=';

        $res = $this->client->request('POST', $uri, [
            'json' => $data
        ]);

        $data = json_decode($res->getBody()->read(1024), true);

        if ($data['status'] != '200') {
            throw new \Exception('Error: '. $data['message']);
        }

        return $data;
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