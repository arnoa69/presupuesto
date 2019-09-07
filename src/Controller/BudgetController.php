<?php

/*
 * This file is part of an exercise.
 * 
 * (c) Alexander Arnold <arnoa69@gmail.com>
 * 
 * There are no LICENSE information
 */
 
namespace App\Controller;

use App\Form\Type\UserType;

use App\Entity\User;
//use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BudgetController extends AbstractController
{

    public function step_one(Request $request){
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('budget_step_two');
        }        

        return $this->render('budget/firstpage.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    public function step_two(){
        $data = "bla";
        return $this->render('budget/secondpage.html.twig', ['data' =>$data]);
    }

    public function step_three(){
        $data = "bla";
        return $this->render('budget/thirdpage.html.twig', ['data' =>$data]);
    }

    public function step_four(){
        $data = "bla";
        return $this->render('budget/fourthpage.html.twig', ['data' =>$data]);
    }
}