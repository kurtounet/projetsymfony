<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashUserPasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function getSubscribedEvents(): array
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

        $entity->setPassword(
            $this->hasher->hashPassword($entity, $entity->getPassword())
        );
    }
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();

        // Type guard
        if (!$entity instanceof User) {
            return;
        }

        // Only hash the password if plainPassword is set
        if ($entity->getPassword()) {
            $hashedPassword = $this->hasher->hashPassword($entity, $entity->getPassword());
            $entity->setPassword($hashedPassword);
            $entity->setPassword(null);
        }
        // $entity->setPassword(
        //     $this->hasher->hashPassword($entity, $entity->getPassword())
        // );
    }
    // private function hashPassword($event): void
    // {
    //     $entity = $event->getObject();

    //     if (!$entity instanceof User) {
    //         return;
    //     }

    //     // Only hash the password if plainPassword is set
    //     if ($entity->getPassword()) {
    //         $hashedPassword = $this->hasher->hashPassword($entity, $entity->getPassword());
    //         $entity->setPassword($hashedPassword);
    //         $entity->setPassword(null);
    //     }
    // }
}
