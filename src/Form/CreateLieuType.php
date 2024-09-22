<?php

namespace App\Form;

use App\Entity\Lieu;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CreateLieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label' => "Nom du lieu"
            ])
            ->add('content', TextType::class,[
                'label' => "Description courte du lieu"
            ])
            ->add('begin_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure d'ouverture du lieu"
            ])
            ->add('end_datetime', null, [
                'widget' => 'single_text',
                'label' => "Date et heure de fermeture du lieu"
            ])
            ->add('imageFile',VichImageType::class,[
                'label' => "Image du lieu"
            ])
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
