<?php


namespace App\Form;


use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImportUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('csvFile', FileType::class, [
                'data_class' => null,
                'required' => true,
                'label' => 'Importer un fichier csv',
                'attr' => array(
                    'accept' => 'text/csv'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}