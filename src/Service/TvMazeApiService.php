<?php
namespace App\Service;

use GuzzleHttp\Client;

class TvMazeApiService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.tvmaze.com/',
            'timeout'  => 2.0,
        ]);
    }

    public function getTalentShowNews()
    {
        $response = $this->client->request('GET', 'schedule');
        $data = json_decode($response->getBody()->getContents(), true);
        $news = [];

        foreach ($data as $entry) {
            if ($entry['_embedded']['show']['type'] === 'Reality') {
                $news[] = [
                    'title' => $entry['_embedded']['show']['name'],
                    'description' => $entry['_embedded']['show']['summary'],
                    'air_date' => $entry['airdate'],
                ];
            }
        }

        return $news;
    }
}
?>