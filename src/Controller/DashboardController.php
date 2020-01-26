<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Dashboards;
use App\Entity\DashboardsFromUser;
use App\Form\DashboardsFormType;
use Symfony\Component\HttpFoundation\JsonResponse;


class DashboardController extends AbstractController
{
	/**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboards(EntityManagerInterface $em, Request $request)
    {
	    //Get user object:
		$user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(DashboardsFromUser::class)->findByUserId($user->getId());
         
        return $this->render('dashboard/dashboards.html.twig', [
	        'data' => $data
        ]);
    }

	
    /**
     * @Route("/dashboard/create", name="dashboard-create")
     */
    public function dashboardCreate(EntityManagerInterface $em, Request $request)
    {
	    $form = $this->createForm(DashboardsFormType::class);
	    
	    $form->handleRequest($request);
	    
	    if ($form->isSubmitted() && $form->isValid()) {
			
			//Get user object:
			$user = $this->getUser();

			//Save data in dashboard table:
			$data = $form->getData();
			$data->setUserId($user);
			$em->persist($data);
			$em->flush();
			
			//Link user to dashboard.
			$entityManager = $this->getDoctrine()->getManager();

	        $DashboardsFromUser = new DashboardsFromUser();
	        $DashboardsFromUser->setUserId($user);
	        $DashboardsFromUser->setDashboardId($data);
	        $DashboardsFromUser->setUserRole('owner');
	        
	        $entityManager->persist($DashboardsFromUser);
	        $entityManager->flush();
           
			$this->addFlash('success', $data->getName().' is aangemaakt!');
			
			return $this->redirectToRoute('dashboard');
		}
	    
        return $this->render('dashboard/dashboardsForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/dashboard/{id}", name="dashboard-view")
     */
    public function dashboard(EntityManagerInterface $em, Request $request, $id)
    {
	    
	    $em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Dashboards::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException('Dashboard does not exist.');
    	}

        // check for "view" access: calls all voters
        //$this->denyAccessUnlessGranted('view', $data);
         
        return $this->render('dashboard/dashboard.html.twig', [
	        'data' => $data,
            'id' => $id
        ]);
    }
    
    /**
     * @Route("/dashboard/{id}/edit", name="dashboard-edit")
     */
    public function dashboardEdit(EntityManagerInterface $em, Request $request, $id)
    {
	    $em = $this->getDoctrine()->getManager();
	    $data = $em->getRepository(Dashboards::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException('Dashboard does not exist.');
    	}
    	
    	$form = $this->createForm(DashboardsFormType::class, $data);
	    
	    $form->handleRequest($request);
	    
	    if ($form->isSubmitted() && $form->isValid()) {
		    
		    $data = $form->getData();
			
			$em->persist($data);
			$em->flush();
			
			$this->addFlash('success', $data->getName().' is gewijzigd!');
	    
			return $this->redirectToRoute('dashboard');
		}
		
		 return $this->render('dashboard/dashboardsForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    
    /**
     * @Route("/dashboard/{id}/delete", name="dashboard-delete")
     */
	public function dashboardDelete(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
	    $data = $em->getRepository(Dashboards::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException('Dashboard does not exist.');
    	}
    	
		$em->remove($data);
		$em->flush();
       
		$this->addFlash('warning', 'Dashboard is verwijderd!');
		
		return $this->redirectToRoute('dashboard');
	}
	
	/**
     * @Route("/dashboards/sort", name="dashboard-sort")
     */
	public function dashboardSort(EntityManagerInterface $em, Request $request )
	{
		
		$sort = $request->getContent();
		
		$i = 0;
		
		foreach (json_decode($sort) as $value)
		{
			$em = $this->getDoctrine()->getManager();
			$data = $em->getRepository(DashboardsFromUser::class)->find($value);
			
			$data->setPosition($i);
			$em->flush();
			$i++;
			
		}
		
		// Send all this back to client
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => 'OK'),
        200);
	}

}