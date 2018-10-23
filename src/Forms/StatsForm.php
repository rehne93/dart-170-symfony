<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 23.10.2018
 * Time: 15:51
 */

namespace App\Forms;


use App\Service\PlayerService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class StatsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $playerService = new PlayerService();
        $names = array();
        $persons = $playerService->getAllPersonNames();
        foreach ($persons as $playerName) {
            $names[$playerName] = $playerName;
        }

        $builder->add('user', ChoiceType::class, array('choices' => $names))
            ->add('submit', SubmitType::class);
    }
}