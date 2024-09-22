<?php

namespace App\Form;

use App\Entity\Performance;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CreatePerformanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom de la performance"
            ])
            ->add('lieu', TextType::class,[
                'label' => "Lieu ou se déroule la performance"
                //Liste à choix à inclure
            ])
            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de début de la performance"
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fin de la performance"
            ])
            ->add('content', TextType::class,[
                'label' => "Description de la performance"
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
