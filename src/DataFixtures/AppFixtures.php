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


class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private SerializerInterface $serializer
    ) {
    }

    private function loadData($file)
    {
        $filename = __DIR__ . '/' . $file;
        return file_get_contents($filename);

        /*
        echo $filename;


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
*/
        // return $data;

    }
    public function load(ObjectManager $manager): void
    {
        // Fixtures User
        /*
         $data = $this->loadData('user.json');
         $users = $this->serializer->deserialize($data, User::class . '[]', 'json');         
         $manager->persist($users);

        $data = json_decode($this->loadData('charactersApi.json'), true);
        foreach ($data as $value) {
            $planet = $value["originPlanet"];
            echo json_encode($planet);
        }

        
                            //$transformations = json_encode($value["transformations"]);
                            //unset($data["originPlanet"], $data["transformations"]);
                            //echo json_encode($value["originPlanet"]["name"]);
                            
                                        $character = [
                                            $data,
                                            ...$value["originPlanet"]["name"],

                                        ];
                            
                            // echo json_encode($data["transformations"]);
                        }

         */
        $data = json_decode($this->loadData('user.json'), true);
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
        echo "Fixtures User created\n";

        $data = json_decode($this->loadData('charactersApi.json'), true);
        ;
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
            $character->setTransformation($value['transformations']);
            // $idPlanet = $value['originPlanet']['id'];

            $planet = new Planet();
            //$planet->seti($value['originPlanet']['name']);
            $planet->setName($value['originPlanet']['name']);
            $planet->setDestroyed($value['originPlanet']['isDestroyed']);
            $planet->setDescription($value['originPlanet']['description']);
            $planet->setImage($value['originPlanet']['image']);
            $planet->setDeletedAt($value['originPlanet']['deletedAt']);
            $manager->persist($planet);
            //$character->setPlanet($idPlanet);

            $manager->persist($planet);
            $manager->persist($character);

        }
        $manager->flush();
        /*
                // Fixtures API
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
                     $idPlanet = $value['originPlanet']['id'];
                     $character->setPlanet($idPlanet);
                     $character->setTransformation($value['transformations']);
                    $manager->persist($character);

                }

        // $manager->flush();
        //echo "Characters created\n";
*/
    }
}
