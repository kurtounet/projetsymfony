<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Planet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Symfony\Bundle\MakerBundle\ApplicationAwareMakerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;


class AppFixtures extends Fixture
{
    public const PLANET_REFERENCE = 'planet-';

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private SerializerInterface $serializer,
        private string $pathDownloadsImagesPlanets,
    ) {
    }

    private function loadData($file)
    {
        $filename = __DIR__ . '/' . $file;
        return file_get_contents($filename);
    }

    public function load(ObjectManager $manager): void
    {
        //PLANETS
        echo "chargement des planets" . PHP_EOL;

        $filename = __DIR__ . '/PlanetsAPI.json';
        $file_content = file_get_contents($filename);
        $planetsArray = $this->serializer->deserialize($file_content, Planet::class . '[]', 'json');
        foreach ($planetsArray as $planet) {
            $localImage = explode('/', $planet->getImage());
            $planet->setImage('planets/' . end($localImage));
            echo end($localImage) . PHP_EOL;

            $manager->persist($planet);
        }

        //$manager->flush();




        echo "chargement des characters" . PHP_EOL;
        $filename = __DIR__ . '/CharactersAPI.json';
        $file_content = file_get_contents($filename);
        //$characters = $this->serializer->deserialize($file_content, Character::class . '[]', 'json');

        $file_content = json_decode($file_content, true);
        $characters = [];
        // dd($characters);
        foreach ($file_content as $character) {
            $characters[] = $character;
            // Récupère le nom de la planète du charactère
            $planetName = $character["originPlanet"]["name"];
            // Récupère les transformations du charactère
            $transformations = $character["transformations"];
            /*
            foreach ($transformations as transformation) {
                if (is_array($value)) {
                    $transformations[$key] = json_encode($value);
                }
            }*/
            // supprimer les proprietés originPlanet et transformations pour laisser seulement 
            //le character -> Entity Character
            unset($character["originPlanet"], $character["transformations"]);
            //convertir null en string "null"
            $character["deletedAt"] = "null";
            $character = json_encode($character);
            $character = $this->serializer->deserialize($character, Character::class, 'json');
            // Attacher le charactère à la planète
            foreach ($planetsArray as $planet) {
                if ($planet->getName() === $planetName) {
                    $character->setPlanet($planet); // $planet->getName();
                    break; // On peut arrêter la boucle dès qu'on trouve la personne
                }
            }
            $character->setTransformation($transformations);
            $manager->persist($character);

        }

        echo "chargement des User" . PHP_EOL;

        $filename = __DIR__ . '/user.json';
        $file_content = file_get_contents($filename);
        $UserArray = $this->serializer->deserialize($file_content, User::class . '[]', 'json');

        foreach ($UserArray as $user) {
            $user->setUserName($user->getFirstName() . $user->getLastName());
            $user->setPassword($user->getPassword());
            // $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
            $manager->persist($user);
        }
        $manager->flush();

    }

}
