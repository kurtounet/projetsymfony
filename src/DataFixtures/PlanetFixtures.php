<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Planet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class PlanetFixtures extends Fixture
{
    public const PLANET_CHARACTER_REFERENCE = 'planet_character';

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private SerializerInterface $serializer
    ) {
    }

    private function loadData($file)
    {
        $filename = __DIR__ . '/' . $file;
        return file_get_contents($filename);


    }

    public function load(ObjectManager $manager): void
    {

        $arrayData = $this->loadData('LocalPlanets.json');
        $arrayPlanets = $this->serializer->deserialize($arrayData, Planet::class . '[]', 'json');
        foreach ($arrayPlanets as $planet) {
            $this->setReference(self::PLANET_CHARACTER_REFERENCE . $planet->getId(), $planet);
            $manager->persist($planet);
        }

        $manager->flush();
    }

}
