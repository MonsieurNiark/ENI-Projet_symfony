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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null,[
                "label" => "Titre :"
            ])
            ->add('datedebut', DateTimeType::class,[
                "label" => "Date de la sortie :"
            ])
            ->add('duree', NumberType::class,[
                "label" => "Duree :"
            ])
            ->add('datecloture', DateType::class,[
                "label" => "Date de fin :"
            ])
            ->add('nbinscriptionsmax', NumberType::class,[
                "label" => "Nombre d'inscriptions :"
            ])
            ->add('descriptioninfos', TextareaType::class,[
                "label" => "Description :"
            ])
            ->add('urlphoto', UrlType::class,[
                "label" => "Ajout d'une photo :"
            ])
/*            ->add('organisateurSortie', EntityType::class, array(

                'class' => Participants::class,
                'label' => 'Organisateur :',
                //Attribut utilisé pour l'affichage
//                'choice_label' => 'nom_Site'

            ))
            ->add('lieuSortie', EntityType::class,array(

                'class' => Lieux::class,
                'label' => 'Lieu de la sortie :',
                //Attribut utilisé pour l'affichage
//                'choice_label' => 'nom_Site'

            ))
            ->add('etatSortie', EntityType::class, array(

                'class' => Etats::class,
                'label' => 'Etat de la sortie :',
                //Attribut utilisé pour l'affichage
//                'choice_label' => 'nom_Site'

            ))
            ->add('siteSortie', EntityType::class, array(

                'class' => Sites::class,
                'label' => 'Site :',
                //Attribut utilisé pour l'affichage
//                'choice_label' => 'nom_Site'

            ))*/;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
