<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Character;
use App\Entity\Contact;
use App\Entity\Planet;
use App\Entity\User;
use App\Models\Message;
use App\Models\TransformationModels;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;


use Faker\Factory;
use Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineTransport;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;



class AppFixtures extends Fixture
{

    public const NB_USERS = 10;

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private SerializerInterface $serializer,
        private string $pathImagesAvatars,
        //private string $pathImagesCharacters,
        //private string $pathImagesTransformations,
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

        $faker = Factory::create();

        $filename = __DIR__ . '/PlanetsAPI.json';
        $file_content = file_get_contents($filename);
        $planetsArray = $this->serializer->deserialize($file_content, Planet::class . '[]', 'json');
        foreach ($planetsArray as $planet) {
            $localImage = explode('/', $planet->getImage());
            $planet->setImage(end($localImage));
            $manager->persist($planet);
        }





        //FIXTURES CHARACTERS
        $filename = __DIR__ . '/CharactersAPI.json';
        $file_content = file_get_contents($filename);
        //$characters = $this->serializer->deserialize($file_content, Character::class . '[]', 'json');

        $file_content = json_decode($file_content, true);
        $characters = [];
        // dd($characters);
        foreach ($file_content as $character) {

            // Récupère le nom de la planète du charactère
            $planetName = $character["originPlanet"]["name"];

            // Récupère les url des image de transformations du charactère pour 
            //  et le adapte pour le chargement de l'image dans le dossier assets/transformations         

            $transformations = $this->serializer->deserialize(json_encode($character["transformations"]), TransformationModels::class . '[]', 'json');
            foreach ($transformations as $transformation) {
                $localImage = explode('/', $transformation->getImage());
                $transformation->setImage(end($localImage));
                //$transformation->setImage($this->pathDownloadsImagesPlanets . $transformation->getImage());
            }
            $transformationsLocal = $this->serializer->serialize($transformations, 'json');// TransformationModels::class . '[]'
            //echo $transformationsLocal . PHP_EOL;

            // Récupère les url de l'image du charactère
            $imageCharacter = $character["image"];

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
            $localImage = explode('/', $imageCharacter);
            $character->setImage(end($localImage));


            $character->setTransformation([$transformationsLocal]);
            $characters[] = $character;
            $manager->persist($character);


        }




        // FIXTURES USER
        $filename = __DIR__ . '/user.json';
        $file_content = file_get_contents($filename);
        $items = json_decode($file_content, true);
        // $UserArray = $this->serializer->deserialize($file_content, User::class . '[]', 'json');

        foreach ($items as $item) {

            $user = new User();
            $address = new Address();
            $address->setNum($item["num"]);
            $address->setStreet($item["street"]);
            $address->setCity($item["city"]);
            $address->setZipcode($item["zipcode"]);
            $address->setCountry($item["country"]);
            $manager->persist($address);

            $user->setFirstName($item["firstName"]);
            $user->setLastName($item["lastName"]);
            $user->setAvatar($item["avatar"]);
            $user->setRoles($item["roles"]);

            $user->setEmail($item["email"]);
            $user->setPassword($item["password"]);

            $user->setCharacterPref($characters[rand(0, 3)]);

            $user->setUserName($item["firstName"] . $item["lastName"]);
            $user->setAddress($address);
            $manager->persist($user);


        }

        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $contact = new Contact();
            $contact
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setMessage($faker->paragraph)
                ->setSubject($faker->sentence)
                ->setCreatedAt($faker->dateTime);
            $manager->persist($contact);
        }

        $manager->flush();

        echo "chargement des Message ok" . PHP_EOL;
        echo "chargement des user ok" . PHP_EOL;
        echo "chargement des characters ok" . PHP_EOL;
        echo "chargement des plantes ok" . PHP_EOL;

    }


}
