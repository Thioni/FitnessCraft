<?php
namespace App\Form;

use App\Entity\Structure;
use App\Entity\FeaturesList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeaturesListType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder 
        ->add("structure", EntityType::class, 
        ["label" => "Quelle structure est concernée ?",
        'class' => Structure::class,
        'multiple' => false,
        'expanded' => false
        ]
        )
        ->add('add_new_members', CheckboxType::class, [
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('send_newsletters', CheckboxType::class, [
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('planning_manager', CheckboxType::class, [
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('sell_drinks', CheckboxType::class, [
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('sell_equipment', CheckboxType::class, [
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('premium_plans', CheckboxType::class, [
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ]);

      }


  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      "data_class" => FeaturesList::class
    ]);
  }

}