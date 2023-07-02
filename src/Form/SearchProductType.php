<?php

namespace App\Form;

use App\Entity\Categories;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class SearchProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Categories',EntityType::class,[
                'class'=>Categories::class,
                'label'=>false,
                'multiple'=>true,
                'required'=>false,
                'attr' =>[
                    'class'=>'js-categories-multiple',
                ]
            ])
            ->add('minPrice', IntegerType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'min'
                ]
            ])
            ->add('maxPrice', IntegerType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'max'
                ]
            ])
            ->add('tags', TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'tags'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
