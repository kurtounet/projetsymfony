<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\GeoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{
    function __construct(
        private UserPasswordHasherInterface $hasher,
        private GeoService $geoService,
        private string $pathImagesAvatars
    ) {

    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        string $pathImagesAvatars
    ): Response {

        $user = new User();
        $user->setAvatar('avatar1.webp');
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Donne les role par defaut 
            $user->setRoles(["ROLE_USER"]);

            $user->setPassword($form->get('password')->getData());
            /** 
             * @var \Symfony\Component\HttpFoundation\File\UploadedFile $avatar 
             * */
            $avatar = $form->get('avatar')->getData();

            if ($avatar) {
                $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $filename = $safeFilename . '-' . uniqid() . '.' . $avatar->guessExtension();
                try {
                    $avatar->move(
                        'uploads/avatars/',
                        $filename
                    );
                    $user->setavatar($filename);
                } catch (FileException $e) {
                    $form->addError(new FormError("Erreur lors de l'upload du fichier"));
                }
            }
            $address = $form->get('address')->getData();
            if (
                $address->getNum() != null &&
                $address->getStreet() != null &&
                $address->getZipcode() != null &&
                $address->getCity() != null &&
                $address->getCountry() != null

            ) {

                $addressCoordinates = $this->geoService->geocode($address);
                $user->setAddress($addressCoordinates);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
            'user' => $user,
        ]);
    }
}
