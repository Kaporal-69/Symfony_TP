<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour', ChoiceType::class, [
                "choices" => [
                    'demain' => new \DateTime('+1 day'),
                    'après-demain' => new \DateTime('+2 days'),
                    'dans 3 jours' => new \DateTime('+3 days'),
                    'dans 4 jours' => new \DateTime('+4 days'),
                    'dans 5 jours' => new \DateTime('+5 days'),
                    'dans 6 jours' => new \DateTime('+6 days'),
                    'dans une semaine' => new \DateTime('+7 days')
                ]])
            ->add('horaire',ChoiceType::class, [
                "choices" =>[
                    "9h" => 9,
                    "10h" => 10,
                    "11h" => 11,
                    "12h" => 12,
                    "13h" => 13,
                    "14h" => 14,
                    "15h" => 15,
                    "16h" => 16,
                    "17h" => 17,
                    "18h" => 18
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
