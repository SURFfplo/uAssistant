<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsItemsController extends AbstractController
{
    /**
     * @Route("/news/items", name="news_items")
     */
    public function index()
    {
        return $this->render('news_items/newsItems.html.twig', [
            'controller_name' => 'NewsItemsController',
        ]);
    }
}
