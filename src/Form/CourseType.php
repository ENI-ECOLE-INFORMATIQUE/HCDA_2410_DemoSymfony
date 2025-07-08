<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;

use App\Entity\Trainer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,['label'=>'Titre'])
            ->add('content',TextareaType::class,['label'=>'Description','required'=>false])
            ->add('duration',IntegerType::class,['label'=>'Durée (jours)'])
            ->add('published',CheckboxType::class,['label'=>'Publié','required'=>false])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'name',
                'placeholder'=>'--Choisir une catégorie--',
                'label'=>'Catégorie'
            ])
            ->add('trainers',EntityType::class,[
                'class'=>Trainer::class,
                'choice_label'=>'fullname',
                'required'=>false,
                'placeholder'=>'Choisir un formateur',
                'label'=>'Formateurs',
                'multiple'=>true
            ])
            ->add('dateCreated', null, [
                'widget' => 'single_text',
            ])
            ->add('dateModified', null, [
                'widget' => 'single_text',
            ])
            /*->add('btnCreate',SubmitType::class,['label'=>'Ajouter'])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
