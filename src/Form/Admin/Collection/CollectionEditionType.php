<?php

namespace App\Form\Admin\Collection;

use App\Entity\CollectionEdition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionEditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('family')
            ->add('picture',FileType::class,[
                'mapped' => false,
                'required'=> false,
                'label' => 'Image article'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'édition'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectionEdition::class,
        ]);
    }
}
