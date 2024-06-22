<?php

namespace App\EventSubscriber;

use App\Service\GeoService;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GeolocationNewUserSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private GeoService $geoService
    ) {
    }


    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }
    public function prePersist(PrePersistEventArgs $event)
    {
        $entity = $event->getObject();

        // Type guard
        if (!$entity instanceof User) {
            return;
        }
        $adress = [
            'num' => $this->$entity->getNum(),
            'street' => $this->$entity->getAdress(),
            'zipCode' => $this->$entity->getZipcode(),
            'city' => $this->$entity->getCity(),
            'country' => $this->$entity->getCountry()
        ];
        $coordinates = $this->geoService->geocode($adress);
        var_dump($coordinates);
        $entity->setLatitude($coordinates[0]["lat"]);
        $entity->setLongitude($coordinates[0]["lon"]);
    }


}
