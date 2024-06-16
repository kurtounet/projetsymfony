<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class FillDatabase
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getData(string $link): string|false
    {
        try {
            $reponse = $this->client->request('GET', $link)->getContent();
            return $reponse;
        } catch (\Exception $e) {
            return false;
        }

    }
    public function downloadImage($url, $path): array|string
    {

        // Initialiser CURL
        $ch = curl_init($url);

        // Définir les options de CURL
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

        // Télécharger l'image
        $raw = curl_exec($ch);
        curl_close($ch);

        if (file_exists($path)) {
            unlink($path); // Assurez-vous de ne pas avoir de fichier dupliqué
        }

        // Sauvegarder le fichier
        if (file_put_contents($path, $raw)) {
            return "Image téléchargée avec succès.";
        } else {
            return "Échec du téléchargement de l'image.";
        }
    }

}