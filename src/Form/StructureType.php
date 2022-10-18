<?php
namespace App\Form;

use App\Entity\Structure;
use App\Entity\Franchisee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder 
        ->add("name", TextType::class, ["label" => "Nom"])
        ->add("adress", TextType::class, ["label" => "Adresse"])
        ->add("manager_email", TextType::class, ["label" => "Email"])
        ->add("managed_by", EntityType::class, [
            "class" => Franchisee::class,
            "label" => "Franchise",
            "multiple" => false,
            "expanded" => false
        ])
        ->add("active", CheckboxType::class, [
            "label" => "Structure active",
            "required" => false,
            'label_attr' => [
              'class' => 'checkbox-switch',
            ]
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      "data_class" => Structure::class
    ]);
  }

}