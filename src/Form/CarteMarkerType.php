<?php

namespace App\Form;

use App\Entity\CarteMarker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarteMarkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lat')
            ->add('lng')
            ->add('name')
            ->add('icon')
            ->add('iconSize')
            ->add('iconAnchor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteMarker::class,
        ]);
    }
}
