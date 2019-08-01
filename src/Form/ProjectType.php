<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picture')
            ->add('name')
            ->add('realized')
            ->add('shortDescription')
            ->add('longDescription')
            ->add('profil', EntityType::class, [
                'class' => Profil::class,
                'choice_label' => 'id'
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'translation_domain' => 'forms'
        ]);
    }
}
