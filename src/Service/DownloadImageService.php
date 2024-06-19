<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class DownloadImageService
{


    public function __construct(
        private HttpClientInterface $client,

    ) {

    }

    public function downloadImage(string $url, string $path): bool
    {
        $filesystem = new Filesystem();

        try {
            $response = $this->client->request('GET', $url);
            if ($response->getStatusCode() === 200) {
                $content = $response->getContent();

                // Vérifie si le dossier existe sinon le creer
                $directory = dirname($path);
                if (!$filesystem->exists($directory)) {
                    $filesystem->mkdir($directory, 0755);
                }

                // enregistre le fichier
                $filesystem->dumpFile($path, $content);
                return true;
            }
        } catch (\Exception $e) {

            return false;
        }

        return false;
    }
}