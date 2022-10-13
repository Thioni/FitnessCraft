<?php
namespace App\Form;

use App\Entity\Structure;
use App\Entity\FeaturesList;
use App\Repository\StructureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeaturesListType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder 
        ->add("structure", EntityType::class, [
        'label' => "Quelle structure est concernée ?",
        'class' => Structure::class,
        'multiple' => false,
        'expanded' => false,
        'query_builder' => function (StructureRepository $er) {
          return $er->createQueryBuilder('u')
              ->orderBy('u.name', 'ASC');
          },
        ])
        ->add('add_new_members', CheckboxType::class, [
          'label' => "Ajout de nouveaux membres",
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('send_newsletters', CheckboxType::class, [
          'label' => "Envoi de newsletters",
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('planning_manager', CheckboxType::class, [
          'label' => "Gestion des plannings",
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('sell_drinks', CheckboxType::class, [
          'label' => "Vente de boissons",
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('sell_equipment', CheckboxType::class, [
          'label' => "Vente d'équipements",
          'required' => false,
          'label_attr' => [
            'class' => 'checkbox-switch',
          ]
        ])
        ->add('premium_plans', CheckboxType::class, [
          'label' => "Abonnements premiums",
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