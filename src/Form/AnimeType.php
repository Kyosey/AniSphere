<?php

namespace App\Form;

use App\Entity\Anime;
use App\Entity\Studio;
use App\Entity\Director;
use App\Entity\Character;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('releaseYear', IntegerType::class)
            ->add('synopsis', TextareaType::class, [
                'required' => false,
            ])
            ->add('episodeCount', IntegerType::class, [
                'required' => false,
            ])
            ->add('durationPerEpisode', IntegerType::class, [
                'required' => false,
            ])
            ->add('studio', EntityType::class, [
                'class' => Studio::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un studio',
                'required' => false,
            ])
            ->add('directors', EntityType::class, [
                'class' => Director::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
            ->add('characters', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anime::class,
        ]);
    }
}
