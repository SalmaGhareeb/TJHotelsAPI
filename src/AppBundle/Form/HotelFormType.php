<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class HotelFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', TextType::class)
                ->add('city', TextType::class)
                ->add('minPrice', NumberType::class)
                ->add('maxPrice', NumberType::class)
                ->add('availableFrom', TextType::class)
                ->add('availableTo', TextType::class)
                ->add('orderBy', TextType::class)
                ->add('orderDirection', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults(
            array(
                'csrf_protection' => false,
            )
        );
    }


    public function getBlockPrefix()
    {
        return 'hotel_form_type';
    }

}