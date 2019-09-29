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
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\Session\Session;

class BudgetController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function step_one(Request $request){
        $booking = new Booking();
        $tab_title = 'Porva dinos que queries?';
        $session = new Session();
        
        var_dump($session->getId());
//var_dump($request->getSession->getId());die();
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
            'form' => $form->createView(),
            'tab_title' => $tab_title,
        ]);
    }

    public function step_two(Request $request){
        $tab_title = 'Elige la categoria?';
        $booking = new Booking();
        $entityManager = $this->getDoctrine()->getManager();
        $get_last_booking_id_obj = $entityManager->getRepository(Booking::class)->findOneBy([], ['id' => 'desc']);

        $form_parent = $this->createForm(ParentCategoryType::class);
        $form = $this->createForm(CategoryType::class, $booking);

        $category = $this->getDoctrine()->getRepository(Category::class);

        if ($_POST) {
            $get_last_booking_id_obj->setCategory($category->find($_POST['category']['id']));
            $get_last_booking_id_obj->setStatusCompleted(0);
            $entityManager->flush();

            return $this->redirectToRoute('budget_step_three');
        }

        return $this->render('budget/secondpage.html.twig', [
            'form_parent' => $form_parent->createView(),
            'form' => $form->createView(),
            'tab_title' => $tab_title,
        ]);
    }

    public function step_three(Request $request){
        $tab_title = 'Dinos quien eres.';        
        $user = new User();        

        $form = $this->createForm(UserType::class, $user);

        $entityManager = $this->getDoctrine()->getManager();
        $get_last_booking_id_obj = $entityManager->getRepository(Booking::class)->findOneBy([], ['id' => 'desc']);        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $get_last_created_user = $entityManager->getRepository(User::class)->findOneBy([], ['id' => 'desc']);
            $get_last_booking_id_obj->setUser($get_last_created_user);
            $get_last_booking_id_obj->setStatusCompleted(1);
            $entityManager->flush();

            return $this->redirectToRoute('budget_step_four');
        }        

        return $this->render('budget/thirdpage.html.twig', [
            'form' =>$form->createView(),
            'tab_title' => $tab_title,
        ]);
    }

    public function step_four(){
        $data = "bla";
        $tab_title = 'Porva dinos que queries?';
        return $this->render('budget/fourthpage.html.twig', [
            'data' =>$data,
            'tab_title' => $tab_title,
            ]);
    }

    public function testCategoryRepo()
    {
        $child_category_select_option_data = array();

        $child_categories = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findChildCategoryByParentId(5);

        foreach($child_categories as $value)
        { 
            $child_category_select_option_data[$value->getId()] = $value->getCategoryName();
        }


        var_dump($child_category_select_option_data);die();
    }

    public function getCategoryId(Request $request){
        $parent_id = $request->get('parent_id');
        $child_category_select_option_data = array();

        $child_categories = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findChildCategoryByParentId($parent_id);

        foreach($child_categories as $value)
        { 
            $child_category_select_option_data[$value->getId()] = $value->getCategoryName();
        }      
        
        $count_sub_categories = count($child_category_select_option_data);

        $response = new Response();
        return $response->setContent(json_encode([
            'data' => $child_category_select_option_data,
        ]));        
    }
}