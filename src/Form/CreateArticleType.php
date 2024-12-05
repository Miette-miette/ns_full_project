<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Titre de l'article",
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
            ->add('sous_titre', TextType::class,[
                'label' => "Sous titre de l'article",
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
            ->add('chapeau',  TextareaType::class,[
                'label' => "Chapeau de l'article",
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
                'label' => "Article complet",
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
                'label' => "Image d'illustration de l'article"
            ])
            ->add('submit',SubmitType::class,[
                'label' => "Ajouter un Article",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
