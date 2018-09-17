<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 17.09.2018
 * Time: 21:52
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SplitItForm extends AbstractType
{
    // TODO New Game Button
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('score', NumberType::class, array('label' => "Letzte Punkte"))
            ->add('submit', SubmitType::class, array('label' => "Getroffen!"));

    }
}