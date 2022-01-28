<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Contact_Name', TextType::class, [
                'required' => true,
                'attr' => ['minlength' => 4],
                'label' => 'Votre Nom'
            ])
            ->add('Email_Contact', EmailType::class, [
                'required' => true,
                'label' => 'Votre e-mail'
            ])
            ->add('Subject_Contact', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Demande de devis' => 'Demande de devis',
                    'Demande de renseignement' => 'Demande de renseignement',
                    'Signaler un bug' => 'Signaler un bug',
                ],
                'label' => 'Raison du contact'
            ])
            ->add('Message_Contact', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'minlength' => 25,
                ],
                'label' => 'Votre message'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je suis pas un robot',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez me cocher.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
