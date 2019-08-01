<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logo')
            ->add('title')
            ->add('desciption')
            ->add('profil', EntityType::class, [
            'class' => Profil::class,
            'choice_label' => 'id'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
            'translation_domain' => 'forms'
        ]);
    }
}
