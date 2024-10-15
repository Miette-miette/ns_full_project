<?php

namespace App\Form;

use App\Entity\Concert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CreateDataConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom de l'artiste/ groupe"
            ])
            ->add('lieu',  TextType::class,[
                'label' => "Scene où se déroule le concert"
            ])
            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de début du concert"
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fin du concert"
            ])
            ->add('content',  TextType::class,[
                'label' => "Petite biographie de l'artiste/ groupe"
            ])
            ->add('imageFile',VichImageType::class,[
                'label' => "Image de l'artiste/ groupe"
            ])
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
        ]);
    }
}
