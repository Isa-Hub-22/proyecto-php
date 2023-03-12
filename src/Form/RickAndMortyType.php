<?php

namespace App\Form;

use App\Entity\RickAndMorty;
use App\Entity\Status;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RickAndMortyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label'=> 'Nombre del personaje',
                'attr' => ['placeholder' => 'Ej. Morty']
            ])
            ->add('descripcion')
            ->add('imagenRickAndMorty', FileType::class, [
                'mapped'=> false
            ])
            ->add('codigo')
            ->add('Statues', EntityType::class, [
                'class' => Status::class,
        
                'choice_label' => 'nombre',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('enviar', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RickAndMorty::class,
        ]);
    }
}
