<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use App\Controller\BudgetController;

$routes = new RouteCollection();
$routes->add('budget_step_one', new Route('/step_one', [
    '_controller' => [BudgetController::class, 'step_one']
]));
$routes->add('budget_step_two', new Route('/step_two', [
    '_controller' => [BudgetController::class, 'step_two']
]));
$routes->add('budget_step_three', new Route('/step_three', [
    '_controller' => [BudgetController::class, 'step_three']
]));
$routes->add('budget_step_four', new Route('/step_four', [
    '_controller' => [BudgetController::class, 'step_four']
]));

return $routes;