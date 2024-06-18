<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class DownloadImageService
{


    public function __construct(
        private HttpClientInterface $client,
        private string $pathDownloadsImagesCharacters,
        private string $pathDownloadsImagesPlanets,
        private string $pathDownloadsImagesTransformations
    ) {

    }

    public function downloadImage(string $url, string $path): bool
    {
        $filesystem = new Filesystem();

        try {
            $response = $this->client->request('GET', $url);
            if ($response->getStatusCode() === 200) {
                $content = $response->getContent();

                // Ensure directory exists
                $directory = dirname($path);
                if (!$filesystem->exists($directory)) {
                    $filesystem->mkdir($directory, 0755);
                }

                // Save the file
                $filesystem->dumpFile($path, $content);
                return true;
            }
        } catch (\Exception $e) {
            // Log the error message or handle it as needed
// e.g., $logger->error($e->getMessage());
            return false;
        }

        return false;
    }
}