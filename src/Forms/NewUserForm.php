<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 03.09.2018
 * Time: 14:47
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label'=>"Name: "))
            ->add('password', PasswordType::class, array('label'=>"Password: "))
            ->add('submit', SubmitType::class);
    }

}