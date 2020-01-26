<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class PersonsController extends AbstractController
{
    /**
     * @Route("/persons", name="persons")
     */
    public function index()
    {
	    //get attributes from authenticated user:
	    //$user = $this->getUser();
		//$uid = $user->getUsername();
		
		//Call OOAPI for profile info:	    
	    $client = HttpClient::create();
		$response = $client->request('GET', 'https://api.test.dlo.surf.nl/persons/11');		
		$content = $response->toArray();
		
		
		
        return $this->render('persons/persons.html.twig', [
            'data' => $content,
        ]);
    }
}
