<?php

/*
 * This file is part of an exercise.
 * 
 * (c) Alexander Arnold <arnoa69@gmail.com>
 * 
 * There are no LICENSE information
 */
 
namespace App\Controller;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Category;
use App\Form\Type\UserType;
use App\Form\Type\BookingType;
use App\Form\Type\CategoryType;
use App\Form\Type\ParentCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BudgetController extends AbstractController
{

    public function step_one(Request $request){
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $booking = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('budget_step_two');
        }        

        return $this->render('budget/firstpage.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    public function step_two(Request $request){
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form_parent = $this->createForm(ParentCategoryType::class, $category);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            var_dump($request->category_name());
        }



        return $this->render('budget/secondpage.html.twig', [
            'form_parent' => $form_parent->createView(),
            'form' => $form->createView(),
        ]);
    }

    public function step_three(Request $request){
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $booking = new Booking();

            return $this->redirectToRoute('budget_step_four');
        }        

        return $this->render('budget/thirdpage.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    public function step_four(){
        $data = "bla";
        return $this->render('budget/fourthpage.html.twig', ['data' =>$data]);
    }
}