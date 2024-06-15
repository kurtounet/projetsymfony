<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Planet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    private function loadData($file)
    {
        $filename = __DIR__ . '/' . $file;
        echo $filename;

        //echo $filename;
        // Check if the file exists
        if (!file_exists($filename)) {
            echo "Erreur : le fichier n'existe pas.";
            return null; // Return early to avoid further processing
        }

        // Attempt to read the file contents
        $fileContents = file_get_contents($filename);
        if ($fileContents === false) {
            echo "Erreur : impossible de lire le fichier.";
            return null;
        }

        // Decode the JSON data
        $data = json_decode($fileContents, true);
        if ($data === null) {
            echo "Erreur : échec du décodage JSON.";
            return null;
        }

        return $data;

    }
    public function load(ObjectManager $manager): void
    {
        //User
        $data = $this->loadData('user.json');
        foreach ($data as $value) {

            $user = new User();
            $user->setFirstName($value['firstName']);
            $user->setLastName($value['lastName']);
            $user->setUserName($value['firstName'] . '' . $value['lastName']);
            $user->setEmail($value['email']);
            $user->setPassword($value['password']);
            $user->setPassword($this->hasher->hashPassword($user, $value['password']));
            $user->setRoles($value['roles']);
            $user->setAvatar($value['avatar']);
            //$user->setCharacterPref($value['characterPref']);
            $manager->persist($user);
        }
        echo "User created\n";

        // Fixtures Planets
        $data = $this->loadData('localPlanets.json');
        foreach ($data as $value) {

            $planet = new Planet();
            $planet->setName($value['name']);
            $planet->setDestroyed($value['isDestroyed']);
            $planet->setDescription($value['description']);
            $planet->setImage($value['image']);
            $planet->setDeletedAt($value['deletedAt']);
            $manager->persist($planet);
        }


        echo "Planets created\n";

        // Fixtures Characters
        $data = $this->loadData('localCharacters.json');
        foreach ($data as $value) {
            $character = new Character();
            $character->setName($value['name']);
            $character->setKi($value['ki']);
            $character->setmaxKi($value['maxKi']);
            $character->setRace($value['race']);
            $character->setGender($value['gender']);
            $character->setDescription($value['description']);
            $character->setImage($value['image']);
            $character->setAffiliation($value['affiliation']);
            $character->setDeletedAt($value['affiliation']);
            /* $idPlanet = $value['originPlanet']['id'];
             $character->setPlanet($idPlanet);
             $character->setTransformation($value['transformations']);*/
            $manager->persist($character);

        }

        $manager->flush();
        echo "Characters created\n";

    }
}
