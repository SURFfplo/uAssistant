<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddButtonController extends AbstractController
{
    /**
     * @Route("/add/button", name="add_button")
     */
    public function index()
    {
        return $this->render('add_button/index.html.twig', [
            'controller_name' => 'AddButtonController',
        ]);
    }
}
