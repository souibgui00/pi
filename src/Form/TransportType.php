<?php
namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Service;
use App\Entity\Transport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart', TextType::class, [
                'label' => 'Heure de départ',
                'attr' => ['placeholder' => 'HH:MM', 'pattern' => '\d{2}:\d{2}'],
            ])
            ->add('pointDepart')
            ->add('destination')
            ->add('vehicule')
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'nom',
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'id',
            ])
        ;

        // Transform string "HH:MM" to DateTime-like string for Doctrine
        $builder->get('heureDepart')
            ->addModelTransformer(new CallbackTransformer(
                function ($stringFromEntity) {
                    // From entity (string) to form (string)
                    return $stringFromEntity; // Assuming stored as "HH:MM:SS"
                },
                function ($stringFromForm) {
                    // From form (string "HH:MM") to entity (string "HH:MM:SS")
                    if (!$stringFromForm) {
                        return null;
                    }
                    // Append ":00" to make it a valid time string
                    return $stringFromForm . ':00';
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transport::class,
        ]);
    }
}