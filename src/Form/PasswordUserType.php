<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actuelPassword', PasswordType::class, [
                'label' => "Votre mot de passe actuel",
                'attr' => ['placeholder' => 'Indiquer votre mot de passe actuel'],
                'mapped' => false 
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'placeholder' => "Choisissez votre nouveau mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => 'Répétez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Répétez votre nouveau mot de passe"
                    ]
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour mon mot de passe",
                'attr' => [
                    'class' => "btn btn-success"
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $user = $form->getConfig()->getOption('data');
                $passwordHasher = $form->getConfig()->getOption('passwordHasher');
              
                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $form->get('actuelPassword')->getData()
                );
                
                if (!$isValid) {
                    $form->get('actuelPassword')->addError(new FormError('Votre mot de passe actuel n\'est pas correct. Veuillez vérifier votre saisie.'));
                }
            });
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null,
        ]);
    }
    
}
