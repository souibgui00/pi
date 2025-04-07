<?php
namespace App\Form;

use App\Entity\Participation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phoneNumber', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Numéro de Téléphone',
                'attr' => ['placeholder' => 'Ex. +216 123 456 78'],
            ])
            ->add('moyenPaiement', ChoiceType::class, [
                'choices' => [
                    'Carte Bancaire' => 'carte_bancaire',
                    'Espèces' => 'especes',
                    'Virement' => 'virement',
                ],
                'required' => true,
                'label' => 'Moyen de Paiement',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}