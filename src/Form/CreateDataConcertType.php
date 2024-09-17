<?php

namespace App\Form;

use App\Entity\Concert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateDataConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom de l'artiste"
            ])
            ->add('lieu')
            ->add('begin_datetime', null, [
                'widget' => 'single_text',
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
            ])
            ->add('content')
            ->add('img')
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
