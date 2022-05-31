<?php

namespace App\Form\Admin\Collection;

use App\Entity\CollectionSubcategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionSubcategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category')
            ->add('picture',FileType::class,[
                'mapped' => false,
                'required'=> false,
                'label' => 'Image article'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de la sous-catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectionSubcategory::class,
        ]);
    }
}
