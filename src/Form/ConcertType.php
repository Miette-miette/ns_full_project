<?php

namespace App\Form;

use App\Entity\Concert;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom de l'artiste/ groupe", 
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
                'class' => Location::class,
                'choice_label' => 'name',
                'label' => "Scene où se déroule le concert",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])

            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de début du concert",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fin du concert",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])
            ->add('content',  TextareaType::class,[
                'label' => "Petite biographie de l'artiste/ groupe",
                'attr' =>[
                    'class'=> 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '6000',
                ],
                'constraints' => [
                    new Assert\Length(['min'=> 2, 'max'=> 6000]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('imageFile',VichImageType::class,[
                'label' => "Image de l'artiste"
            ])
            

            ->add('submit',SubmitType::class,[
                'label' => "Ajouter un concert",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
        ]);
    }
}
