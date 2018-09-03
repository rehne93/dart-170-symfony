<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 03.09.2018
 * Time: 14:42
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class Game170Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numRounds', NumberType::class, array('label' => "Rounds needed: "))
            //->add('date', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Save'));
    }
}