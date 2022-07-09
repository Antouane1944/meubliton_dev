<?php

namespace App\Form;
use App\StaticClass;
use App\Entity\Annonce;
use App\Entity\Avatar;
use App\Repository\AvatarRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddAnnonceFormType extends AbstractType
{
    //private VilleRepository $VilleRepository
    public function __construct(private AvatarRepository $AvatarRepository){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $choicesData = [];
        $a = (array) $this->AvatarRepository->findAll();
        for($i = 0; $i < count($a); $i++){
            $choicesData[$a[$i]->getId()] = $a[$i]->getNom();
        }


        $builder
            ->add('titre', TextType::class, ['label' => 'Titre'])
            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('prix', TextType::class, ['label' => 'Prix'])
            //->add('ville', EntityType::class, [
            //    'class' => Ville::class,
            //    'choice_label' => 'nom',
            //    'placeholder' => 'Choisir une ville'
            //])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter']);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
