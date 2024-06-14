<?php

namespace App\Command;

use App\Entity\Character;
use App\Service\CallApiService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'call-api',
    description: 'Add a short description for your command',
)]
class CallApiCommand extends Command
{
    const API_URL_BASE = 'https://dragonball-api.com/api/';

    private const DIR_FIXTURES = '/../DataFixtures//';
    private const INFO_CHARACTER = 'https://dragonball-api.com/api/characters';
    private const INFO_PLANET = 'https://dragonball-api.com/api/planets';
    private $httpClient;

    public function __construct(HttpClientInterface $client)
    {
        $this->httpClient = $client;

        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        // $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        $pathDirFixtures = __DIR__ . self::DIR_FIXTURES;
        $io = new SymfonyStyle($input, $output);
        $callApiService = new CallApiService($this->httpClient);

        /**************Planètes***************/
        // Appel API pour recupérer les infos sur le nombre de planètes 
        $planets = json_decode($callApiService->getData(self::INFO_PLANET), true);
        //construit l'url , page 1 , limit = itemsPerPage * totalPages = toute les planètes en 1 fois
        $url = '?page=1&limit=' . strval($planets["meta"]["itemsPerPage"] * $planets["meta"]["totalPages"]);
        //Appel API pour recupérer toute les planètes
        $planets = json_decode($callApiService->getData(self::INFO_PLANET . $url), true);
        //Appel API pour recupérer tout les planètes         
        file_put_contents(
            $pathDirFixtures . 'Planets.json',
            json_encode($planets["items"])
        );
        echo "Planètes : récupére avec succes !" . PHP_EOL;


        /**************Personnage***************/
        /**
         * Problèmes : 
         * 1. les id des personnages sont discontinue. ils existent sur les plage: 1 à 35, 37 à 40, 42 à 44, 63 à 78 .
         * 2. les infos sur les personnages sont incomplète pour un appel générale, il manque 
         * les informations sur les transformations du personnage et sa planète d'origine.
         * 
         * 
         * Résolution : 
         * 1. Un appel général des personnages, pour récupérer les id existant.
         * 2. Faire une boucle pour récupérer les personnages, un par un , par leur id.
         */
        // Appel API pour recupérer les id des Personnages + pagination  
        // pagination => "totalItems": 58,"itemCount": 10,"itemsPerPage": 10,"totalPages": 6,"currentPage": 1
        $infosCharacters = json_decode($callApiService->getData(self::INFO_CHARACTER), true);
        $url = '?page=1&limit=' . strval($infosCharacters["meta"]["itemsPerPage"] * $infosCharacters["meta"]["totalPages"]);
        $AllCharacters = $callApiService->getData(self::INFO_CHARACTER . $url);
        //$character = $serializer->deserialize($AllCharacters, Character::class, 'json');

        // echo $character->getName();
        /*
                $JSON = [];
                for ($i = 1; $i < 58; $i++) {
                    //construit l'url , page 1 , limit = itemsPerPage * totalPages = toute les planètes en 1 fois
                    $url = '?page=' . strval($i + 1) . '&limit=' . strval($characters["meta"]["itemsPerPage"]);
                    //Appel API pour recupérer toute les planètes
                    $data = $callApiService->getData(self::INFO_CHARACTER . "/" . $i);
                    if ($data != false) {
                        $JSON[] = json_decode($callApiService->getData(self::INFO_CHARACTER . "/" . $i), true);
                    } else {

                    }

                    //Appel API pour recupérer tout les planètes  


                }
                file_put_contents(
                    $pathDirFixtures . 'characters.json',
                    json_encode($JSON)
                );
                
                //construit l'url , page 1 , limit = itemsPerPage * totalPages = toute les planètes en 1 fois
                $url = '?page=1&limit=' . strval($characters["meta"]["itemsPerPage"] * $characters["meta"]["totalPages"]);
                //Appel API pour recupérer toute les planètes
                $characters = json_decode($callApiService->getData(self::INFO_CHARACTER . $url), true);
                //Appel API pour recupérer tout les planètes         
                file_put_contents(
                    $pathDirFixtures . 'characters.json',
                    json_encode($characters["items"])
                );*/
        echo "Personnages : récupére avec succes !" . PHP_EOL;

















        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
