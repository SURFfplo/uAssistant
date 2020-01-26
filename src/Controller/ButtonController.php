<?php

namespace App\Controller;

use App\Entity\Buttons;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ButtonController extends AbstractController
{
    /**
     * @Route("/button", name="button")
     */
    public function index()
    {
        $data = $this->getDoctrine()
            ->getRepository(Buttons::class)
            ->findAll();

        return $this->render('button/button.html.twig', [
            'data' => $data
        ]);
    }
}