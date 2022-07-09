<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Repository\AvatarRepository;
use App\Form\AddAnnonceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

class AjouterAnnonceController extends AbstractController
{

    public function __construct(private AvatarRepository $AvatarRepository){}

    #[Route('/ajouter-annonce', name: 'app_add_annonce')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AddAnnonceFormType::class, $annonce);

        if ($form->isSubmitted() && $form->isValid()) {

            // AJOUTER APRES VALIDATION

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('add_annonce.html.twig', [
            'ajouterAnnonce' => $form->createView()
        ]);
    }
}
