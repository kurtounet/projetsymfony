<?php
namespace App\Service;

use App\Entity\Address;
use App\Models\AddressModels;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function geocode(Address $address): Address
    {

        $response = $this->client->request('GET', 'https://nominatim.openstreetmap.org/search', [
            'query' => [
                'num' => $address->getNum(),
                'street' => $address->getStreet(),
                'zipCode' => $address->getZipcode(),
                'city' => $address->getCity(),
                'country' => $address->getCountry(),
                'latitude' => $address->getLatitude(),
                'longitude' => $address->getLongitude(),
                'format' => 'json'
            ]
        ]);

        if (count($response->toArray()) != 0) {
            $addressResponse = $response->toArray()[0];
            $address->setLatitude($addressResponse['lat']);
            $address->setLongitude($addressResponse['lon']);
        }
        return $address;


    }
}