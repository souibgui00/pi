<?php
namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextType::class, [
                'label' => 'Message',
                'attr' => ['placeholder' => 'Décrivez votre réclamation', 'class' => 'form-control'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (preuve)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'L’image est requise.']),
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG ou PNG).',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('pass', TextType::class, [
                'label' => 'Mot de passe (pour suivi)',
                'attr' => ['placeholder' => 'Entrez un mot de passe pour suivre votre réclamation', 'class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}