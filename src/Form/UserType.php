<?php
namespace App\Form;

use App\Entity\Structure;
use App\Entity\Franchisee;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder 
        ->add("email", TextType::class, ["label" => "Email"])
        ->add("password", TextType::class, ["label" => "Mot de passe temporaire"])
        ->add("franchisee_account", EntityType::class, [
          "class" => Franchisee::class,
          "label" => "Franchise",
          "placeholder" => 'Séléctionnez un franchisé',
          "multiple" => false,
          "expanded" => false,
          "required" => true,
          "data" => null
          ])
          ->add("structure_account", EntityType::class, [
            "class" => Structure::class,
            "label" => "Structure",
            "placeholder" => 'Séléctionnez une structure',
            "multiple" => false,
            "expanded" => false,
            "required" => true,
            "data" => null
          ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      "data_class" => User::class
    ]);
  }

}