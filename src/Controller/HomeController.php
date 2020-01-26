<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DashboardsFromUser;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        //Get user object:
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(DashboardsFromUser::class)->findByUserId($user->getId());

        if (!$data) {
            return $this->render('home/noDashboard.html.twig', []);
        }

        $id = $data[0]->getDashboardId()->getId();

        return $this->redirectToRoute('dashboard-view', array('id' => $id ));
    }
    
    public function mainMenu($id)
    {
	    //Get user object:
		$user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $mainMenu = $em->getRepository(DashboardsFromUser::class)->findByUserId($user->getId());
        
        return $this->render('base-menu.html.twig', [
            'menu' => $mainMenu,
            'id' => $id
        ]);
    }
}
