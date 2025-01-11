<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'required'=>true,
                'help'=>'Auteur de l\'article',
                'label'=>'Auteur',
                'constraints'=>[
                    new Assert\NotBlank([
                        'message'=> 'Un article a forcément un auteur...'
                    ]),
                    new Assert\Type("string"),
                    new Assert\Length([
                        'min'=>3,
                        'max'=>255,
                        'maxMessage'=>"255 caractères max",
                        "minMessage"=>"3 caractère minimum",
                    ]),
                ]

            ])
            ->add('title', TextType::class, [
                'required'=>true,
                'help'=>'Le titre de l\'article',
                'label'=>'Titre',
                'constraints'=>[
                    new Assert\NotBlank([
                        'message'=> 'le titre de l\'article est obligatoire'
                    ]),
                    new Assert\Type("string"),
                    new Assert\Length([
                        'min'=>3,
                        'max'=>255,
                        'maxMessage'=>"255 caractères max",
                        "minMessage"=>"3 caractère minimum",
                    ]),
                ]
            ])
            // ->add('publication_date', DateTimeType::class, [
            //     'required'=>true,
            //     'label'=>'Date d\'échéance',
            //     'empty_data'=> (new \DateTime('now'))->format('Y-m-d:i'),
            //     'constraints'=>[
            //         new Assert\Type("\dateTimeInterface")

            //     ],
            // ])
            ->add('comment', TextareaType::class,[
                // 'required'=>true,
                'label'=>'Comment faire ?',
                'attr' => [
                    'class' => 'tinymce2',
                    'id' => 'textareaTinymce',
                ],
                

                'constraints'=>[
                    new Assert\NotBlank([
                        'message'=> 'Vous ne pouvez pas faire un article vide'
                    ]),
                    new Assert\Type("string"),
                    new Assert\Length([
                        'min'=>3,
                        "minMessage"=>"3 caractères minimum pour votre article",
                    ]),
                ]
            ])
            ->add('Publier',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
