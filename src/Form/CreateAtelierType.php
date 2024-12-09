<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',  TextType::class,[
                'label' => "Nom de l'atelier",
                'attr' =>[
                    'class'=> 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'constraints' => [
                    new Assert\Length(['min'=> 2, 'max'=> 50]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('Location', EntityType::class, [
                'label' => "Lieu où se déroule l'atelier",
                'class' => Location::class,
                'choice_label' => 'name',
                'attr' =>[
                    'class'=> 'form-control'
                ],
            ])


            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de début de l'atelier",
                'attr' =>[
                    'class'=> 'form-control'
                ]
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fin de l'atelier",
                'attr' =>[
                    'class'=> 'form-control'
                ]
            ])
            ->add('content',  TextareaType::class,[
                'label' => "Description de l'atelier",
                'attr' =>[
                    'class'=> 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'constraints' => [
                    new Assert\Length(['min'=> 2, 'max'=> 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('imageFile',VichImageType::class,[
                'label' => "Image d'illustration de l'atelier"
            ])

            ->add('submit',SubmitType::class,[
                'label' => "Ajouter un atelier",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Atelier::class,
        ]);
    }
}
