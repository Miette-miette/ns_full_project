<?php

namespace App\Form;

use App\Entity\Partenaire;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CreatePartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom du partenaire"
            ])
            ->add('type', TextType::class,[
                'label' => "Type de partenaire"
                //inclure des choix
            ])
            ->add('content', TextType::class,[
                'label' => "Courte description du partenaire"
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
