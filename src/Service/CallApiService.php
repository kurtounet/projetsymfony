<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


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


}