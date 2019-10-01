<?php

namespace App\Form;

use App\Entity\Sites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSite',EntityType::class,array(
                'class' => Sites::class,
                'label' => 'Site',
                'choice_label' => 'nom_Site'
            ))

            ->add('nomSortie', TextType::class,array(
                'label' => 'Le nom de la sortie contient'
            ))

            ->add('dateDebut',DateType::class)

            ->add('dateFin',DateType::class)

            ->add('estOrganisateur',CheckboxType::class, array(
                'label' => 'Sorties dont je suis l\'organisateur/trice ',
                'required' => false
            ))

            ->add('estInscrit',CheckboxType::class, array(
                'label' => 'Sorties auxquelles je suis inscrit/e ',
                'required' => false
            ))

            ->add('estPasInscrit',CheckboxType::class, array(
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false
            ))

            ->add('sortiePasse',CheckboxType::class, array(
                'label' => 'Sorties passées',
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
