<?php

namespace App\Form;

use App\Entity\Atelier;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CreateAtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',  TextType::class,[
                'label' => "Nom de l'atelier"
            ])
            ->add('lieu',  TextType::class,[
                'label' => "Lieu où se déroule l'atelier"
            ])
            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de début de l'atelier"
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fin de l'atelier"
            ])
            ->add('content',  TextType::class,[
                'label' => "Description de l'atelier"
            ])
            ->add('imageFile',VichImageType::class,[
                'label' => "Image d'illustration de l'atelier"
            ])
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Atelier::class,
        ]);
    }
}
