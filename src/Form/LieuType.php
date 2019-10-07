<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLieu', null, [
                "label" => "Nom du lieu :"
            ])
            ->add('rue', null, [
                "label" => "rue :"
            ])
            ->add('latitude', NumberType::class, [
                "label" => "latitude :"
            ])
            ->add('longitude', NumberType::class, [
                "label" => "longitude :"
            ])
            ->add('villeLieu', EntityType::class, array(
                'class' => Villes::class,
                'label' => 'Villes : ',
                //Attribut utilisé pour l'affichage
                'choice_label' => 'nomVille'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieux::class,
        ]);
    }
}
