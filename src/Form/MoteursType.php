<?php

namespace App\Form;

use App\Entity\Moteurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Vich\UploaderBundle\Form\Type\VichImageType;

class MoteursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                    'placeholder' => 'Marque',
                ],
                'label' => 'Marque',
                'constraints' => [
                    new Length(['min' => 2, 'max' => 50]),
                    new NotBlank(),
                ],
            ])
            ->add('prix', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ],
                'label' => 'Prix (en €)',
                'constraints' => [
                    new Positive(),
                    new LessThan(20000),
                ],
            ])
            ->add('ref', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Référence',
                ],
                'label' => 'Référence',
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Description',
                ],
                'label' => 'Description',
            ])
            ->add('imageName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de l\'image',
                ],
                'label' => 'Nom de l\'image',
            ])
            ->add('updateAt', null, [
                'widget' => 'single_text',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('cylinder', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Cylindre',
                ],
                'label' => 'Cylindre',
            ])->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Image (JPEG file)',
            ])
            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
                'label' => 'Créer mon moteur'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moteurs::class,
        ]);
    }
}
