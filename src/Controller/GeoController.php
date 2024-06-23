<?PHP

namespace App\Controller;


use App\Models\AddressModels;
use App\Service\GeoService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoController extends AbstractController
{


    public function __construct(

        private GeoService $geoService
    ) {

    }

    #[Route('/geocode', name: 'geocode')]
    public function geocode(
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();
        $address = $user->getAddress();


        if ($user) {
            $addressCoordinates = $this->geoService->geocode($address);
            $user->setAddress($addressCoordinates);
            $em->persist($user);
            $em->flush();
        }
        return new Response(json_encode($addressCoordinates));




        /*
        $this->geoService->geocode($address);
        $user->setLatitude($address->getLatitude());
        $user->setLongitude($address->getLongitude());
        $coordinates = [
            'latitude' => $address->getLatitude(),
            'longitude' => $address->getLongitude()
        ];
        var_dump($coordinates);
        return json_encode($coordinates);*/


    }
}
