<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class, 
                'mapped' => false,
                'invalid_message' =>'Le mot de passe et la confirmation doivent être identiques',
                'required' => true,
                'first_options' => [
                    'label' =>'Nouveau mot de passe :',
                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe :'                   
                ],                
                'constraints' => [
                  new Length([
                    'min' => 8,
                    'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                    'max' => 4096
                  ]),
                  new Regex([
                    'pattern' => "$(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\W])$",
                    'message' => 'Votre mot de passe doit inclure au moins une majuscule, une minuscule, un chiffre et un caractère spécial.'
                  ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}