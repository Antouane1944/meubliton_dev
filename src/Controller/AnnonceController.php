<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Task;
use App\Repository\AnnonceRepository;
use App\Repository\TagRepository;
use App\Repository\TagCategoryRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceController extends AbstractController
{

    public function __construct(private AnnonceRepository $AnnonceRepository, private TagRepository $TagRepository, private TagCategoryRepository $TagCategoryRepository){}

    #[Route('/annonces', name: 'liste_annonces')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()
                    ->add('prix_min', IntegerType::class, ['label' => 'Prix min'])
                    ->add('prix_max', IntegerType::class, ['label' => 'Prix max'])
                     ->add('appliquer', SubmitType::class, ['label' => 'Appliquer les filtres'])
                     ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $array_tags = [];
                $nb_tag = count($this->TagRepository->findAll());
                for($i = 1; $i <= $nb_tag; $i++){
                    if ($request->request->get('check-'.$i)){
                        array_push($array_tags, $i);
                    }
                }
            $prix_min = $form->get('prix_min')->getData();
            $prix_max = $form->get('prix_max')->getData();
            if ($prix_min == null){
                $prix_min = 0;
            }
            if ($prix_max == null){
                $prix_max = 100000;
            }
            $annonces = $this->AnnonceRepository->getAnnoncebyFilter($prix_min, $prix_max);
        } else {
            $annonces = $this->AnnonceRepository->findAll();
            $array_tags = [];
        }
            
        return $this->render('annonces.html.twig', [
            'annonces' =>  $annonces,
            'form' => $form->createView(),
            'tag_category' => $this->TagCategoryRepository->findAll(),
            'array_selected_tags' => $array_tags
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
