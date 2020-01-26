<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Buttons;

use App\Form\ButtonsFormType;

class SettingsController extends AbstractController
{
    /**
     * @Route("/settings/buttons", name="settings")
     */
    public function index()
    {
	    $data = $this->getDoctrine()
        ->getRepository(Buttons::class)
        ->findAll();

        return $this->render('settings/settings.html.twig', [
            'data' => $data,
        ]);
    }
    
    
    /**
     * @Route("/settings/buttons/create", name="settings-add-button")
     */
    public function buttonNew(EntityManagerInterface $em, Request $request)
    {
	    $form = $this->createForm(ButtonsFormType::class);
	    
	    $form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			$em->persist($data);
			$em->flush();
			$id = $data->getId();
           
			//$this->addFlash('success', $person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' is aangemaakt!');
			
			return $this->redirectToRoute('settings', array('id' => $id));			
		}
		
        return $this->render('settings/settingsButtonsForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/settings/buttons/{id}/edit", name="settings-edit-button")
     */
	public function ButtonEdit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Buttons::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException('Button does not exist');
    	}
		        
		$form = $this->createForm(ButtonsFormType::class, $data);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			
			$em->persist($data);
			$em->flush();
           
			//$this->addFlash('success', 'Muziekinstrument: '.$musicalInstrument->getMusicalInstrument().' is bijgewerkt!');
			
			return $this->redirectToRoute('settings');			
		}
		
		return $this->render('settings/settingsButtonsForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $data
		]);
	}
	
	/**
     * @Route("/settings/buttons/{id}/delete", name="settings-delete-button")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Buttons::class)->find($id);
		
		if (!$data) {
        	throw $this->createNotFoundException('The button does not exist');
    	}

			$em->remove($data);
			$em->flush();
           
			//$this->addFlash('warning', 'Het muziekinstrument is verwijderd!');
			
			return $this->redirectToRoute('settings');			
	}

}