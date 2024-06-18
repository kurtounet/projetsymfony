<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\DownloadImageService;
use Symfony\Component\Routing\Attribute\Route;

class DownloadController extends AbstractController
{


    public function __construct(
        private DownloadImageService $downloadImageService
    ) {

    }
    #[Route('/download', name: 'app_download')]
    public function downloadAction(): Response
    {
        $url = "https://dragonball-api.com/characters/goku_normal.webp";
        $path = $this->getParameter('kernel.project_dir') . '/public/downloads/characters/goku_normal.webp';

        $success = $this->downloadImageService->downloadImage($url, $path);

        return new Response($success ? 'Image téléchargée avec succès.' : "Échec du téléchargement de l'image.");
    }
}