<?php

namespace App\Form;

use App\Entity\Partenaire;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom du partenaire",
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
            ->add('type', TextType::class,[
                'label' => "Type de partenaire",
                'attr' =>[
                    'class'=> 'form-control',
                ]
                //inclure des choix
            ])
            ->add('content', TextType::class,[
                'label' => "Courte description du partenaire",
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
                'label' => "Logo du partenaire"
            ])
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
