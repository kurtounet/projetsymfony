<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function geocode(array $address): array
    {

        $response = $this->client->request('GET', 'https://nominatim.openstreetmap.org/search', [
            'query' => [
                'num' => $address['num'],
                'street' => $address['street'],
                'zipCode' => $address['zipCode'],
                'city' => $address['city'],
                'country' => $address['country'],
                'format' => 'json'
            ]
        ]);

        if (count($response->toArray()) != 0) {
            $address = $response->toArray()[0];
        }
        $coordinates = [
            'lat' => $address['lat'],
            'lon' => $address['lon'],
        ];
        return $response->toArray();
    }
}