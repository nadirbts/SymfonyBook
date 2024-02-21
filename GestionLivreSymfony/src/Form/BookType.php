<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\DBAL\Types\SmallIntType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Console\Color;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn', TextType::class, ['label' => 'ISBN :'])
            ->add('titre', TextType::class, ['label' => 'Titre :'])
            ->add('resumer', TextareaType::class, ['label' => 'Resumer:'])
            ->add('description', TextareaType::class, ['label' => 'Description :'])
            ->add('prix', NumberType::class, [
                'label' => 'Prix :',
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Au dessus de 0 $ '
                    ]),
                    new LessThan([
                    'value' => 200,
                    'message' => 'En dessous de 200 $ ',
                ])
                ]
                ,
                

            ])
            
            ->add('author',EntityType::class,[
                 'label' => 'Choisir l\'auteur:',
                'class' => Author::class    ,
               
                'choice_label'=> function (Author $author) {
                    return $author->getName();
                },
                
            
                
                ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
