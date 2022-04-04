<?php

namespace App\Form;

use App\Entity\Calculation;
use App\Entity\CountryTax;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cost', null ,[
              'attr' => [
                'type' => 'number',
                'step' => '0.01',
                'min' => '0'
              ]
            ])
            ->add('rate', EntityType::class ,[
              'class' => CountryTax::class,
              'placeholder' => 'Select VAT tax code..',
              'mapped' => true
            ])
            ->add('Save', SubmitType::class, [

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calculation::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'calc_token',
        ]);
    }
}
