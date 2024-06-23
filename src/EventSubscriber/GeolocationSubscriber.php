<?php

namespace App\EventSubscriber;

use App\Event\AddressRegisteredEvent;
use App\Models\AddressModels;
use App\Service\GeoService;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(AddressRegisteredEvent::NAME, 'addressRegistered')]
class GeolocationSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private GeoService $geoService
    ) {
    }

    public function addressRegistered(
        AddressRegisteredEvent $event
    ): void {
        $entity = $event->getObject();
        

        if (!$entity instanceof Address) {
            return;
        }

        $coordinates = $this->geoService->geocode($entity);
        $entity->setLatitude($coordinates['lat']);
        $entity->setLongitude($coordinates['lon']);

    }
    public static function getSubscribedEvents(): array
    {
        return [

            Events::preUpdate
        ];
    }
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();

        // Type guard
        if (!$entity instanceof User) {
            return;
        }

        if ($entity) {
            $address = new AddressModels(
                $entity->getNumAdress(),
                $entity->getAdress(),
                $entity->getCity(),
                $entity->getZipcode(),
                $entity->getCountry(),
                null,
                null
            );
            dd($address);
            echo "MISE A JOUR\n";
            //$this->geoService->geocode($address);
            //dd($address); récupere les coordonees
            // $entity->setLatitude($address->getLatitude());
            // $entity->setLongitude($address->getLongitude());
        }
    }


}
