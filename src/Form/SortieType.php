<?php

namespace App\Form;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Titre :',
                'attr' => ['id' => 'form_nom']
            ))
            ->add('datedebut', DateTimeType::class, array(
                'label' => 'Date de la sortie :',
                'widget' => 'single_text'
            ))
            ->add('duree', NumberType::class, array(
                "label" => "Duree :"
            ))
            ->add('datecloture', DateTimeType::class, array(
                'label' => 'Date de cloture :',
                'widget' => 'single_text'
            ))
            ->add('nbinscriptionsmax', NumberType::class, array(
                'label' => 'Nombre d\'inscriptions :'
            ))
            ->add('descriptioninfos', TextareaType::class, array(
                'label' => 'Description :'
            ))
            ->add('urlphoto', FileType::class, [
                'data_class' => null,
                'required' => false,
                'label' => 'Ajout d\'une photo :',

                'attr' => array(
                    'accept' => 'image/*'
                )])
            ->add('lieuSortie', EntityType::class, array(

                'class' => Lieux::class,
                'label' => 'Lieu de la sortie :',
                'choice_label' => 'nomLieu',
                'attr' => array('class' => 'lieuxclass')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
