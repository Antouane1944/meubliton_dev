<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Task;
use App\Repository\AnnonceRepository;
use App\Repository\TagRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class AnnonceController extends AbstractController
{

    public function __construct(private AnnonceRepository $AnnonceRepository, private TagRepository $TagRepository){}

    #[Route('/annonces', name: 'liste_annonces')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()
                    ->add('prix_min', TextType::class, ['label' => 'Prix min'])
                    ->add('prix_max', TextType::class, ['label' => 'Prix max'])
                     ->add('tags', EntityType::class, [
                        'class' => Tag::class,
                        'choice_label' => 'nom',
                        'placeholder' => 'Choisir un tag'
                    ])
                     ->add('Appliquer', SubmitType::class)
                     ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $prix_min = $form->get('prix_min')->getData();
            $prix_max = $form->get('prix_max')->getData();
            $annonces = $this->AnnonceRepository->getAnnoncebyFilter($prix_min, $prix_max);	
        } else {
            $annonces = $this->AnnonceRepository->findAll();
        }
            
        return $this->render('annonces.html.twig', [
            'annonces' =>  $annonces,
            'form' => $form->createView()
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
