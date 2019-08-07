<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('title')
            // ->add('desciption')
            ->add('desciption', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
            ->add('profil', EntityType::class, [
            'class' => Profil::class,
            'choice_label' => 'email'
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
