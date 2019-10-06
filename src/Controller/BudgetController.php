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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

    /* First of three forms to get a complete booking dataset
     *
     * In case the user goes backward, check if the last entered
     * dataset 
     * 
     * @return object of view / redirect
     */
    public function step_one(Request $request){
        $booking = new Booking();
        $tab_title = 'Porva dinos que queries?';

        $form = $this->createForm(BookingType::class, $booking);

        $open_booking_obj = $this->entityManager->getRepository(Booking::class)
                                                       ->findOneBy([], ['id' => 'desc']);

        if($open_booking_obj->getSession() === $this->get('session')->getId() AND 
           $open_booking_obj->getStatusCompleted() >= 1)
        {
            $form = $this->createFormBuilder($open_booking_obj)
                ->add('booking_description', TextareaType::class)
                ->add('booking_date', ChoiceType::class, [
                    'choices' => [
                        'Los antes posible' => 'now',
                        'De 1 a 3 meses' => 'quarter_year',
                        'Mas de 3 meses' => 'up_to_year',
                    ],
                ])
                ->add('save', SubmitType::class, array('label' => 'update'))
                ->getForm();
            
            $form->handleRequest($request);

            if($form->isSubmitted()){
                $open_booking_obj = $form->getData();
                $this->entityManager->flush();
                return $this->redirectToRoute('budget_step_two');
            }

            return $this->render('budget/firstpage.html.twig', [
                'form' => $form->createView(),
                'tab_title' => $tab_title,
            ]);            
        } else {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $form_data_obj = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
    
                $booking->setBookingDescription($form_data_obj->getBookingDescription());
                $booking->setBookingDate($form_data_obj->getBookingDate());
                $booking->setSession($this->get('session')->getId());   
                $booking->setStatusCompleted(1);
    
                $entityManager->persist($booking);
                $entityManager->flush();
    
                return $this->redirectToRoute('budget_step_two');
            }        
    
            return $this->render('budget/firstpage.html.twig', [
                'form' => $form->createView(),
                'tab_title' => $tab_title,
            ]);
        }       
    }

    public function step_two(Request $request){
        $tab_title = 'Elige la categoria?';
        $booking = new Booking();

        $get_last_booking_id_obj = $this->entityManager->getRepository(Booking::class)->findOneBy([], ['id' => 'desc']);

        $form_parent = $this->createForm(ParentCategoryType::class);
        $form = $this->createForm(CategoryType::class, $booking);

        $category = $this->getDoctrine()->getRepository(Category::class);

        if ($_POST) {
            $get_last_booking_id_obj->setCategory($category->find($_POST['category']['id']));
            $get_last_booking_id_obj->setStatusCompleted(2);
            $this->entityManager->flush();

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
            'session' => $this->get('session')->getId(),
        ]);
    }

    public function step_four(){
        $data = "bla";
        $tab_title = 'Porva dinos que queries?';
        return $this->render('budget/fourthpage.html.twig', [
            'data' =>$data,
            'tab_title' => $tab_title,
            'session' => $this->get('session')->getId(),
            ]);
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