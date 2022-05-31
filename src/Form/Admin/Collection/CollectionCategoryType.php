<?php

namespace App\Form\Admin\Collection;

use App\Entity\CollectionCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture',FileType::class,[
                'mapped' => false,
                'required'=> false,
                'label' => 'Image de la Categorie'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de la catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectionCategory::class,
        ]);
    }
}
