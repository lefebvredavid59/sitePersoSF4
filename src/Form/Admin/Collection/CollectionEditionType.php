<?php

namespace App\Form\Admin\Collection;

use App\Entity\CollectionEdition;
use App\Entity\CollectionFamily;
use App\Entity\CollectionSubcategory;
use App\Repository\CollectionFamilyRepository;
use App\Repository\CollectionSubcategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionEditionType extends AbstractType
{

    public function __construct(private CollectionFamilyRepository $collectionFamilyRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Image de l\'édition :',
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'édition'
            ])
            ->add('subcategory', EntityType::class, [
                'class' => CollectionSubcategory::class,
                'choice_label' => 'name',
                'placeholder' => 'Selectionner la sous-categorie',
                'query_builder' => fn(CollectionSubcategoryRepository $subcategoryRepository) =>
                $subcategoryRepository->findAllOrderedByAscNameQueryBuilder()
            ]);

        $formModifier = function (FormInterface $form, CollectionSubcategory $collectionSubcategory = null) {
            $familys = $collectionSubcategory === null ? [] : $this->collectionFamilyRepository->findByCollectOrderByAscName($collectionSubcategory);

            $form->add('family', EntityType::class, [
                'class' => CollectionFamily::class,
                'choice_label' => 'name',
                'disabled' => $collectionSubcategory === null,
                'placeholder' => 'Sélectionner la famille',
                'choices' => $familys
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getSubcategory());
            }
        );

        $builder->get('subcategory')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $subcategory = $event->getForm()->getData();

                $formModifier($event->getForm()->getParent(), $subcategory);
            }
        );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CollectionEdition::class,
        ]);
    }
}
