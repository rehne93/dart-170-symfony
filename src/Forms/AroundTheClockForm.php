<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 08.09.2018
 * Time: 16:24
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AroundTheClockForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('numDarts', NumberType::class, array('label' => 'Darts benötigt'))
            ->add('bullIncluded', CheckboxType::class, array('label' => "(Single) Bull inklusive"))
            ->add('submit', SubmitType::class, array('label' => "Speichern"));
    }

}