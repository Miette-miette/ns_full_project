<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Performance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePerformanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom de la performance",
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
                'label' => "Date et heure de début de la performance",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fin de la performance",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])
            ->add('content', TextType::class,[
                'label' => "Description de la performance",
                'attr' =>[
                    'class'=> 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '6000',
                ],
                'constraints' => [
                    new Assert\Length(['min'=> 2, 'max'=> 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('imageFile',VichImageType::class,[
                'label' => "Image d'illustration de la performance"
            ])
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Performance::class,
        ]);
    }
}
