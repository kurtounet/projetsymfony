<?php

namespace App\Command;

use App\Entity\Character;
use App\Entity\Planet;
use App\Repository\PlanetRepository;
use App\Service\CallApiService;
use App\Service\DownloadImageService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'call-api',
    description: 'Fetches data from an API and populates the database with planets and characters data.'
)]
class CallApiCommand extends Command
{
    private const API_URL_BASE = 'https://dragonball-api.com/api/';
    private const DIR_FIXTURES = '/../DataFixtures/';
    private const ENDPOINT_CHARACTER = self::API_URL_BASE . 'characters';
    private const INFO_PLANET = self::API_URL_BASE . 'planets';



    public function __construct(
        private SerializerInterface $serializer,
        private CallApiService $callApiService,
        private DownloadImageService $downloadImageService,
        private EntityManagerInterface $entityManager,
        private PlanetRepository $planetRepository,
        private string $pathImagesCharacters,

        private string $pathImagesTransformations,
    ) {

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // PLANETS
        $planets = json_decode($this->callApiService->getData(self::INFO_PLANET), true);
        $totalItems = $planets["meta"]["itemsPerPage"] * $planets["meta"]["totalPages"];
        $planets = json_decode($this->callApiService->getData(self::INFO_PLANET . "?page=1&limit=$totalItems"), true);

        // Téléchargement des images des planètes
        foreach ($planets['items'] as $item) {
            $tab = explode('/', $item['image']);
            $nameImage = end($tab);
            echo 'téléchargement de : ' . $item['image'] . "\n";
            $this->downloadImageService->downloadImage(
                $item['image'],
                'public/assets/planets/' . $nameImage
            );
        }
        // Sauvegarde des planètes dans le fichier json
        file_put_contents(
            __DIR__ . self::DIR_FIXTURES . 'PlanetsAPI.json',
            json_encode($planets['items'])
        );

        //CHARGER LES PLANETES DANS LA BASE DE DONNEES
        /*
        foreach ($planets['items'] as $item) {
            $planet = new Planet();
            $planet->setName($item['name']);
            $planet->setIsDestroyed($item['isDestroyed']);
            $planet->setDescription($item['description']);
            $planet->setDeletedAt($item['deletedAt']);
            $planet->setImage($item['image']);
            $this->entityManager->persist($planet);
        }

        $this->entityManager->flush();
        */
        $io->success(' Toutes les planètes ont été importées!');


        // CHARACTERS
        /**
         *  PROBLEME: les Id des characters ne suivent pas( il y a des plage vide).
         *  RESOLUTION: Récupérer tout id existant, puis récupérer les personnage un par
         *  un, car qui ils contiennet les données, des planètes et des transformations. 
         */


        // 1er appel à l API pour récuperer itemsPerPage et totalPages.
        $characters = json_decode($this->callApiService->getData(self::ENDPOINT_CHARACTER), true);
        $totalItems = $characters["meta"]["itemsPerPage"] * $characters["meta"]["totalPages"];
        /// 2eme appel à l API pour récuperer tout les id
        $characters = $this->callApiService->getData(self::ENDPOINT_CHARACTER . "?page=1&limit=$totalItems");
        //var_dump($characters);

        $ids = [];
        $i = 1;
        // 3eme appel à 1 par 1 les characters id. 

        foreach (json_decode($characters, true)['items'] as $item) {

            $ids[] = $item['id'];
            echo 'Image Characters : ' . $item['image'] . "\n";
            $tabNameImage = explode('/', $item['image']);
            $nameImage = end($tabNameImage);

            $this->downloadImageService->downloadImage(
                $item['image'],
                'public/assets/characters/' . $nameImage
            );

            $character = $this->callApiService->getData(self::ENDPOINT_CHARACTER . '/' . $item['id']);
            // Téléchargement des image de transformations

            foreach (json_decode($character, true)['transformations'] as $transformation) {
                $url = $transformation['image'];
                $nameTransformationImage = explode('/', $transformation['image']);
                $this->downloadImageService->downloadImage(
                    $url,
                    'public/assets/transformations/' . end($nameTransformationImage)
                );

                echo 'Image Transformation : ' . $url . PHP_EOL;
            }

            //$tabTransformationImage = explode('/', $character["transformations"]['image']);
            $character = json_decode($character, true);

            $Allcharacters[] = $character;
            // echo ' - ' . json_decode($character, true)['name'] . ': OK' . PHP_EOL;
        }



        $io->success('Tous les personnages ont été importés ! ' . PHP_EOL);
        echo 'Liste des id :' . PHP_EOL;
        echo json_encode($ids, true);
        file_put_contents(
            __DIR__ . self::DIR_FIXTURES . 'charactersApi.json',
            json_encode($Allcharacters)
        );
        $io->success('Fichier charactersApi.json a été crée dans le dossier: src/DataFixtures');


        /*
                echo "CHARGEMENT DES DONNES EN BASE DE DONNÉES" . PHP_EOL;
                echo "chargement des planets en base de Données" . PHP_EOL;

                $filename = __DIR__ . '/LocalPlanets.json';
                $file_content = file_get_contents($filename);
                $planetsArray = $this->serializer->deserialize($file_content, Planet::class . '[]', 'json');
                foreach ($planetsArray as $planet) {
                    $this->entityManager->persist($planet);
                    // $this->setReference(self::PLANET_REFERENCE . $planet->getId(), $planet);
                }

                // $manager->flush();


                echo "chargement des characters" . PHP_EOL;
                $filename = __DIR__ . '/LocalCharacters.json';
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
                    $this->entityManager->persist($character);

                }

                echo "chargement des User" . PHP_EOL;

                $filename = __DIR__ . '/user.json';
                $file_content = file_get_contents($filename);
                $UserArray = $this->serializer->deserialize($file_content, User::class . '[]', 'json');

                foreach ($UserArray as $user) {
                    $user->setUserName($user->getFirstName() . $user->getLastName());
                    $user->setPassword($user->getPassword());
                    // $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
                    $this->entityManager->persist($user);
                }
                $this->entityManager->flush();
        */

        return Command::SUCCESS;
    }
}
/* 3eme appel à l API pour récuperer un par un les id.
       foreach ($ids as $id) {
           $character = new Character();
           $character = $this->callApiService->getData(self::INFO_CHARACTER . "/$id");
           $character = $this->serializer->deserialize($character, Character::class, 'json');
           $this->entityManager->persist($character);
       }
       $this->entityManager->flush();*/
/*
$totalItems = $characters["meta"]["itemsPerPage"] * $characters["meta"]["totalPages"];
$characters = json_decode($this->callApiService->getData(self::INFO_CHARACTER . "?page=1&limit=$totalItems"), true);
echo $characters['items'][0]['id'];*/
/*
foreach ($characters['items'] as $item) {
    $character = new Character();
    $character->setName($item['name']);
    $character->setDescription($item['description']);
    $this->entityManager->persist($character);
}
$this->entityManager->flush();*/








/*
        // Fetch and deserialize all planets
        $planetData = json_decode($this->callApiService->getData(self::INFO_PLANET . "?page=1&limit=1000"), true);
        foreach ($planetData["items"] as $planetJson) {
            // Assuming each $planetJson is a JSON string of a single Planet object
            $planet = $this->serializer->deserialize(json_encode($planetJson), Planet::class, 'json');
            $this->entityManager->persist($planet);

            // Optional: Output the planet data for debugging
            echo json_encode($planetJson) . "\n";
        }
        $this->entityManager->flush();
        /*
        foreach ($planets as $planet) {
            $this->entityManager->persist($planet);
        }
        $this->entityManager->flush(); 
        $io->success('All planets have been imported successfully!');
        /*
                // Fetch and deserialize characters
                $characterData = $this->callApiService->getData(self::INFO_CHARACTER . "?page=1&limit=1000");
                $characters = $this->serializer->deserialize($characterData, 'App\Entity\Character[]', 'json');
                foreach ($characters as $character) {
                    $this->entityManager->persist($character);
                }
                $this->entityManager->flush();
                $io->success('All characters have been imported successfully!');
        */
