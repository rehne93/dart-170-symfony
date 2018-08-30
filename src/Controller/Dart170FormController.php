<?php

namespace App\Controller;

use App\model\Dart170;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;


class Dart170FormController extends AbstractController
{

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private $logger;

    /**
     * @Route("/dart170", name="dart170_form")
     */
    public function new(Request $request){
        $dartStats = new Dart170();
        $dartStats->setDate(new \DateTime('today'));
        $dartStats->setNumRounds(3);

        $form = $this->createFormBuilder($dartStats)
            ->add('numRounds',NumberType::class)
            ->add('date',DateType::class)
            ->add('save',SubmitType::class, array('label' => 'Speichern'))
            ->getForm();



        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $dartStats = $form->getData();
            $this->logger->info("Form Rounds: " . $dartStats->getNumRounds());
            // TODO Return
        }

        return $this->render('dart170_form/index.html.twig',array('form' => $form->createView()));
    }
}
