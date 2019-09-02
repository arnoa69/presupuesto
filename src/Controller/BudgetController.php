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
//use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BudgetController extends AbstractController
{

    public function step_one(){
        $data = "bla";
        return $this->render('budget/firstpage.html.twig', ['data' =>$data]);
    }
}