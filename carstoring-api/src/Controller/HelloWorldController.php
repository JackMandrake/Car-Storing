<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    /**
     * @Route("/", name="hello_world")
     */
    public function homepage()
    {
        return $this->render('hello_world/homepage.html.twig', [
            'controller_name' => 'HelloWorldController',
        ]);
    }
}
