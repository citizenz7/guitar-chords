<?php

namespace App\Form;

use App\Entity\Chord;
use App\Model\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchChordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher une accords',
                    'class' => 'form-control',
                    'id' => 'search',
                    'placeholder' => 'Entrez une lettre ou un titre complet d\'accord'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chord::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}