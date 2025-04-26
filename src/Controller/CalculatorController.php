<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Calculator;
use App\Repository\CalculatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CalculatorFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalculatorController extends AbstractController
{
    #[Route('/calculator', name: 'calculator_app')]
    public function index(Request $request): Response
    {
        $calculator = new Calculator();
        $form = $this->createForm(CalculatorFormType::class, $calculator);
        $form->handleRequest($request);
        $result = null;
        //check if the values in the form are valid or not
        if ($form->isSubmitted() && $form->isValid()) {
              $data=$form->getData();
            $number1 = $data['number1'];
            $number2 = $data['number2'];
            $operator = $data['operator'];

            switch ($operator) {
                case '+':
                    $result = $number1 + $number2;
                    break;
                case '*':
                    $result = $number1 * $number2;
                    break;
                case '/':
                    if ($number2 == 0) {
                        $result = 'division by zero';
                    } else {
                        $result = $number1 / $number2;
                    }
                    break;
                case '-':
                    $result = $number1 - $number2;
                    break;
                default: 
                    $result = 'no option found!';
            }
        }
        return $this->render(
            'calculator/calculator.html.twig',
            [
                'calculatorForm' => $form->createView(),
                'result' => $result

            ]

        );

    }
}
