<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickName', textType::class,[
                'required' => true,
                'label' => 'Votre pseudo :',
                'constraints' => [
                    new Assert\NotBlank([
                        'message'=> 'le pseudo est obligatoire'
                    ]),
                    new Assert\Type("string"),
                    new Assert\Length([
                        'max'=>255,
                        'min'=>3,
                        'maxMessage'=>"50 caractères max",
                        "minMessage"=>"3 caractères minimum",
                    ]),
                ]
            ])
            ->add('password', passwordType::class,[
                'required' => true,
                'label' => 'Votre Mot de passe :',
                'hash_property_path' => 'password',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message'=> 'le mot de passe est obligatoire'
                    ]),
                    new Assert\Type("string"),
                    new Assert\Length([
                        'max'=>20,
                        'min'=>8,
                        'maxMessage'=>"20 caractères max",
                        "minMessage"=>"8 caractères minimum",
                    ]),
                ]
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
