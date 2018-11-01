<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 01.11.2018
 * Time: 19:26
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class DoubleLimitForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('finished', SubmitType::class, array('label' => 'Finished'))
            ->add('notFinished', SubmitType::class, array('label' => 'Not Finished'))
            ->add('reset', SubmitType::class, array('label' => 'Reset'));
    }
}