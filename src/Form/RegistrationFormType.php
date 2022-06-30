<?php

namespace App\Form;
use App\StaticClass;
use App\Entity\User;
use App\Entity\Ville;
use App\Entity\Region;
use App\Entity\Avatar;
use App\Repository\VilleRepository;
use App\Repository\RegionRepository;
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

class RegistrationFormType extends AbstractType
{

    public function __construct(private VilleRepository $VilleRepository, private AvatarRepository $AvatarRepository){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $choicesData = [];
        $a = (array) $this->AvatarRepository->findAll();
        for($i = 0; $i < count($a); $i++){
            $choicesData[$a[$i]->getId()] = $a[$i]->getNom();
        }


        $builder
            ->add('pseudo')
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            
            ->add('avatar', EntityType::class, [
                'class' => Avatar::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un Avatar'
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une région'
            ]);

            $formModifier = function (FormInterface $form, Region $region = null) {
                $villes = $region === null ? [] : $this->VilleRepository->findBy(['region' => $region]);
                $form->add('ville', EntityType::class, [
                    'class' => Ville::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisir une ville',
                    'disabled' => $region === null,
                    'choices' => $villes
                ]);
            };
    
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier) {
                    $data = $event->getData();
    
                    $formModifier($event->getForm(), $data->getRegion());
                }
            );
    
            $builder->get('region')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {
                    $region = $event->getForm()->getData();
    
                    $formModifier($event->getForm()->getParent(), $region);
                }
            );
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
