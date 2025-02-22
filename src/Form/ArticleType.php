<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Chord;
use App\Entity\Tonalite;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('intro')
            ->add('content')
            ->add('mainImage')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('isActive')
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('tonalite', EntityType::class, [
                'class' => Tonalite::class,
                'choice_label' => 'id',
            ])
            ->add('accords', EntityType::class, [
                'class' => Chord::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
