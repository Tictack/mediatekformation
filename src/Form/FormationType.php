<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class, [
                'data' => isset($options['data']) &&
                    $options['data']->getPublishedAt() != null ? 
                    $options['data']->getPublishedAt() : new DateTime('now'),
                'label'=> 'Date'
            ])
            ->add('title', null, [
                'label'=> 'Titre',
                'required' => true
            ])
            ->add('description', null, [
                'required' => false
            ])
            ->add('videoId', null, [
                'label'=> 'Id Youtube',
                'required' => true
            ])
            ->add('playlist', EntityType::class, [
                'class'=> Playlist::class,
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('categories', EntityType::class, [
                'class'=> Categorie::class,
                'choice_label' => 'name',
                'required' => false,
                'multiple' => true
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
