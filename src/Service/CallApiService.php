<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getData(string $link): string|false
    {
        try {
            $reponse = $this->client->request('GET', $link)->getContent();
            return $reponse;
        } catch (\Exception $e) {
            return false;
        }

    }
    public function downloadImage($link): array
    {
        $file = get_file_contents("https://dragonball-api.com/characters/goku_normal.webp");
        $response = $this->client->request(
            'GET',
            'https://dragonball-api.com/api/planets?page=' . '&limit=10'
        );
        return $response->toArray();
    }




}