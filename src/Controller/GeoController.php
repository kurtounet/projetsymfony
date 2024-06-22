<?PHP

namespace App\Controller;


use App\Service\GeoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoController extends AbstractController
{


    public function __construct(
        private HttpClientInterface $client,
        private GeoService $geoService
    ) {

    }

    #[Route('/geocode', name: 'geocode')]
    public function geocode()
    {
        $address = [
            'num' => '10',
            'street' => 'chemin des saules',
            'zipCode' => '69570',
            'city' => 'dardilly',
            'country' => 'france',
        ];

        $coordinates = $this->geoService->geocode($address);
        var_dump($coordinates);
        return json_encode($coordinates);

    }
}
