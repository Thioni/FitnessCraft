<?php
namespace App\Form;

use App\Entity\Franchisee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseeType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder 
        ->add("name", TextType::class, ["label" => "Nom"])
        ->add("email", TextType::class, ["label" => "Email"])
        ->add('active', CheckboxType::class, [
          'label' => "Franchisé actif",
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      "data_class" => Franchisee::class
    ]);
  }

}