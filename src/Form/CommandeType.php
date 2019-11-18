<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormBuilder;
use App\Entity\Billet;
use App\Form\BilletType;


class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        for ($i = 1; $i < 12; $i++) {
            $NbBillets[] = $i;
        }
        $builder
            ->add('DateCommande', DateType::class, array(
                'label' => 'Date de la visite',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
            ))
            ->add('Formule', ChoiceType::class, array(
                'label' => 'Type du billet',
                'choices' => array(
                    'Journée' => false,
                    'Demi-Journée' => true,),
            ))
            ->add('NbBillet', ChoiceType::class, array(
                'label' => 'Nombre de billets',
                'required' => true,
                'choices' => $NbBillets
            ))

            ->add('email', EmailType::class, array(
                'required' => true,
            ));

        $builder
            ->add('billets', CollectionType::class, array(
                'label' => 'Suivant',
                'entry_type' => BilletType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

            ))
            ->add('valider',SubmitType::class, array(
                'attr'=>array(
                    'class'=>'btn btn-primary')
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
