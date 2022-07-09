<?php
// src/Controller/UserController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Entity\Annonce;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    public function __construct(private AnnonceRepository $AnnonceRepository){}

    public function index(Request $request): Response
    {
        return $this->render('profil.html.twig', [
            'annonces' => $this->AnnonceRepository->findBy(["vendeur" => $this->getUser()]),
        ]);
    }
}