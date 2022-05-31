<?php

namespace App\Form\Admin\Blog;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label'=> 'Titre de l\'article :'
            ])
            ->add('picture',FileType::class,[
                'mapped' => false,
                'required'=> false,
                'label' => 'Image article'
            ])
            ->add('movie',TextType::class,[
                'label'=> 'Video Youtube :',
                'required'=>false,
            ])
            ->add('content', CKEditorType::class)
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
