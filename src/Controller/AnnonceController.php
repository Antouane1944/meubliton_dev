<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Repository\TagRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{

    public function __construct(private AnnonceRepository $AnnonceRepository, private TagRepository $TagRepository){}

    #[Route('/annonces', name: 'liste_annonces')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('annonces.html.twig', [
            'annonces' =>  $this->AnnonceRepository->findAll(),
            'tags' => $this->TagRepository->findAll()
        ]);
    }
}
