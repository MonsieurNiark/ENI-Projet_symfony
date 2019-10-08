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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                "label" => "Titre :"
            ])
            ->add('datedebut', DateTimeType::class, [
                "label" => "Date de la sortie :"
            ])
            ->add('duree', NumberType::class, [
                "label" => "Duree :"
            ])
            ->add('datecloture', DateTimeType::class, [
                "label" => "Date de cloture des inscriptions :"
            ])
            ->add('nbinscriptionsmax', NumberType::class, [
                "label" => "Nombre d'inscriptions :"
            ])
            ->add('descriptioninfos', TextareaType::class, [
                "label" => "Description :"
            ])
            ->add('urlphoto', UrlType::class, array(
                'label' => 'Ajout d\'une photo :',
                'required' => false
            ))
            ->add('lieuSortie', EntityType::class, array(

                'class' => Lieux::class,
                'label' => 'Lieu de la sortie :',
                'choice_label' => 'nomLieu',
                'attr' => array('class' => 'lieuxclass')
            ));

//        $formModifier = function (FormInterface $form, Sites $site = null) {
//            $lieux = null === $site ? [] : $site->getSortiesSite();
//            var_dump($lieux);
//            $form->add('lieuSortie', EntityType::class, array(
//
//                'class' => Lieux::class,
//                'label' => 'Lieu de la sortie :',
//                'mapped' => false,
//                'choice_label' => 'nom_lieu'
//            ));
//        };
//
//        $builder->addEventListener(FormEvents::PRE_SET_DATA,
//            function (FormEvent $event) use ($formModifier) {
//                $data = $event->getData();
//
//                $formModifier($event->getForm(), $data->getSiteSortie());
//            });
//
//        $builder->get('siteSortie')->addEventListener(
//            FormEvents::POST_SUBMIT,
//            function (FormEvent $event) use ($formModifier) {
//                $site = $event->getForm()->getData();
//
//                $formModifier($event->getForm()->getParent(), $site);
//            }
//        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
