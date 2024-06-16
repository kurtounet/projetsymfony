<?php

namespace App\Command;

use App\Entity\Character;
use App\Entity\Planet;
use App\Repository\PlanetRepository;
use App\Service\CallApiService;
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

    private $serializer;
    private $callApiService;
    private $entityManager;
    private $planetRepository;

    public function __construct(
        SerializerInterface $serializer,
        CallApiService $callApiService,
        EntityManagerInterface $entityManager,
        PlanetRepository $planetRepository
    ) {
        $this->serializer = $serializer;
        $this->callApiService = $callApiService;
        $this->entityManager = $entityManager;
        $this->planetRepository = $planetRepository;
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






        /*
                $planets = json_decode($this->callApiService->getData(self::INFO_PLANET), true);
                $totalItems = $planets["meta"]["itemsPerPage"] * $planets["meta"]["totalPages"];
                $planets = json_decode($this->callApiService->getData(self::INFO_PLANET . "?page=1&limit=$totalItems"), true);

                foreach ($planets['items'] as $item) {
                    $planet = new Planet();
                    $planet->setName($item['name']);
                    $planet->setDestroyed($item['isDestroyed']);
                    $planet->setDescription($item['description']);
                    $planet->setDeletedAt($item['deletedAt']);
                    $planet->setImage($item['image']);
                    $this->entityManager->persist($planet);
                }
                $this->entityManager->flush();
                $io->success(' Toutes les planètes ont été importées!');

        */

        /*
        PROBLEME: les Id des characters ne suivent pas( il y a des plage vide).
        RESOLUTION: Récupérer tout id existant, puis récupérer les personnage un par
        un, car qui ils contiennet les données, des planètes et des transformations.
        */
        /* 1er appel à l API pour récuperer itemsPerPage et totalPages.*/
        $characters = json_decode($this->callApiService->getData(self::ENDPOINT_CHARACTER), true);
        $totalItems = $characters["meta"]["itemsPerPage"] * $characters["meta"]["totalPages"];
        /* 2eme appel à l API pour récuperer tout les id*/
        $characters = json_decode($this->callApiService->getData(self::ENDPOINT_CHARACTER . "?page=1&limit=$totalItems"), true);
        $ids = [];
        $i = 1;
        /* 3eme appel à 1 par 1 les characters id.*/
        foreach ($characters['items'] as $item) {
            $ids[] = $item['id'];
            $character[] = $this->callApiService->getData(self::ENDPOINT_CHARACTER . '/' . $item['id']);
            echo $i++ . '/' . count($characters['items']) . ' - ' . $item['name'] . ': OK' . PHP_EOL;
        }

        $io->success('Tous les personnages ont été importés ! ' . PHP_EOL);
        echo 'Liste des id :' . PHP_EOL;
        echo json_encode($ids, true);
        file_put_contents(
            __DIR__ . self::DIR_FIXTURES . 'charactersApi.json',
            json_encode($character)
        );
        $io->success('Fichier charactersApi.json a été crée dans le dossier: src/DataFixtures');
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


        return Command::SUCCESS;
    }
}
