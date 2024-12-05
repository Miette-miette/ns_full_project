<?php

namespace App\Form;

use App\Entity\Concert;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom de l'artiste/ groupe"
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
                'label' => "Image de l'artiste"
            ])
            ->add('Location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'label' => "Scene où se déroule le concert"
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
