<?php


namespace App\Form;


use App\Entity\Participants;
use App\Entity\Sites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nom d\'utilisateur : '
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom : '
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom : '
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email : '
            ))
            ->add('telephone', TextType::class, array(
                'label' => 'Telephone : '
            ))
            ->add('siteParticipant', EntityType::class,  array(

                'class' => Sites::class,
                'label' => 'Site : ',
                //Attribut utilisé pour l'affichage
                'choice_label' => 'nom_Site'

            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe : '),
                'second_options' => array('label' => 'Repetez le mot de passe : '),
                'invalid_message' => 'Your passwords do not match!',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
