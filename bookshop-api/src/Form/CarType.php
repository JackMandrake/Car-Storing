<?php

namespace App\Form;

use App\Entity\Car;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "name",
            TextType::class,
            [
                "label" => "Nom du véhicule"
            ]
        );

        $builder->add(
            "nbSeat",
            IntegerType::class,
            [
                "label" => "Nombre de place"
            ]
        );

        $builder->add(
            "color",
            ColorType::class,
            [
                "label" => "Couleur du véhicule"
            ]
        );

        $builder->add(
            "height",
            NumberType::class,
            [
                "label" => "Longueur du véhicule"
            ]
        );

        $builder->add(
            "width",
            NumberType::class,
            [
                "label" => "Largeur du véhicule"
            ]
        );
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}