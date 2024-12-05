<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;


class CreateLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class,[
                'label' => "Nom du lieu",
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
            ->add('content', TextareaType::class,[
                'label' => "Description courte du lieu",
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

            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure d'ouverture du lieu",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fermeture du lieu",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])

            ->add('lat',null,[
                'label' => "Latitude",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])

            ->add('lng',null,[
                'label' => "Longitude",
                'attr' =>[
                    'class'=> 'form-control',
                ]
            ])
         
            /*->add('icon',VichImageType::class,[
                'label' => "Icone du lieu"
            ])*/


            ->add('imageFile',VichImageType::class,[
                'label' => "Image du lieu"
            ])
            ->add('submit',SubmitType::class,[
                'label' => "Ajouter un lieu",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
