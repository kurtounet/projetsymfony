<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Planet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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



    }

    public function load(ObjectManager $manager): void
    {
        echo "chargement des planets";
        $filename = __DIR__ . '/LocalPlanets.json';
        $file_content = file_get_contents($filename);
        $planets = $this->serializer->deserialize($file_content, Planet::class . '[]', 'json');
        //$users = json_decode($file_content, true);
        //dd($users);
        foreach ($planets as $planet) {

            $manager->persist($planet);
        }
        $manager->flush();

        echo "chargement des planets";
        $filename = __DIR__ . '/LocalCharacters.json';
        $file_content = file_get_contents($filename);
        $characters = $this->serializer->deserialize($file_content, Character::class . '[]', 'json');

        foreach ($characters as $character) {
           /* $Character = json_decode($value, true);
            $idplanet = $Character["originPlanet"]["id"];*/
            $transformations = $data["transformations"];
            unset($data["originPlanet"], $data["transformations"]);
            $data["deletedAt"] = "null";
            $characters = json_encode($data);
            $characters = $this->serializer->deserialize($characters, Character::class, 'json');
           // $characters->setPlanet($this->getReference(PlanetFixtures::PLANET_CHARACTER_REFERENCE . $idplanet)); // $characters
            $characters->setDeletedAt('null');
            $characters->setTransformation($transformations);
            /*
            $planet = json_encode($data["originPlanet"]);
            $planet = $this->serializer->deserialize($planet, Planet::class, 'json');
            $namePlanet = $planet->getName();

            $manager->persist($character);
        }
        $manager->flush();

        /*
        echo "chargement des user";
        $filename = __DIR__ . '/user.json';
        $file_content = file_get_contents($filename);
        $users = $this->serializer->deserialize($file_content, User::class . '[]', 'json');
        //$users = json_decode($file_content, true);
        //dd($users);
        foreach ($users as $user) {

            $manager->persist($user);
        }
        $manager->flush();
         
        echo "chargement des user";
        $filename = __DIR__ . '/user.json';
        $file_content = file_get_contents($filename);
        $users = $this->serializer->deserialize($file_content, User::class . '[]', 'json');
        //$users = json_decode($file_content, true);
        //dd($users);
        foreach ($users as $user) {

            $manager->persist($user);
        }
        $manager->flush();

         
                echo "chargement des characters";
                echo $this->loadData('LocalCharacters.json');

                echo "chargement des characters";
                echo $this->loadData('LocalCharacters.json');
         */
    }

}


/*
        foreach ($arrayCharacters as $value) {
            $Character = json_decode($value, true);
            $idplanet = $Character["originPlanet"]["id"];
            $transformations = $data["transformations"];
            unset($data["originPlanet"], $data["transformations"]);
            $data["deletedAt"] = "null";
            $characters = json_encode($data);
            $characters = $this->serializer->deserialize($characters, Character::class, 'json');
            $characters->setPlanet($this->getReference(PlanetFixtures::PLANET_CHARACTER_REFERENCE . $idplanet)); // $characters
            $characters->setDeletedAt('null');
            $characters->setTransformation($transformations);
            /*
            $planet = json_encode($data["originPlanet"]);
            $planet = $this->serializer->deserialize($planet, Planet::class, 'json');
            $namePlanet = $planet->getName(); 






 
                        foreach ($arrayPlanets as $planet) {
                            $planet = json_decode(json_encode($planet), true);
                            if ($planet["id"] == $idplanet) {
                                $characters->setPlanet($planet);
                            }

                        }
            


            $manager->persist($characters);






        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            PlanetFixtures::class,
        ];
    }  
}
 
         
                              //
                              
                                          $character = [
                                              $data,
                                              ...$value["originPlanet"]["name"],

                                          ];
                              
                              // echo json_encode($data["transformations"]);
                          }

                  
       
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
        $data = $this->loadData('charactersApi.json');

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


