<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('address', EntityType::class,[
                'class'=>Adress::class,
                'required' =>true,
                'choices' =>$user->getAdresses(),
                'multiple' =>false,
                'expanded' =>true
            ])
            ->add('carrier', EntityType::class,[
                'class'=>Carrier::class,
                'required' =>true,
                'multiple' =>false,
                'expanded' =>true
            ])
            ->add('informations', TextareaType::class, [
                'required' =>false,
            ])
       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user'=>array(),

        ]);
    }
}
