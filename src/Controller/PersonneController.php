<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="app_personne")
     */
    public function index(PersonneRepository $repo): Response
    {
        $personnes = $repo->findAll();
        return $this->render('personne/index.html.twig', compact('personnes'));
    }


    /**
     * @Route("/personne/ajouter", name="app_personne_ajouter")
     */
    public function ajouter(EntityManagerInterface $em,Request $request):Response
    {
        $personne = new Personne(); 

        $formPersonne =  $this->createForm(PersonneType::class, $personne); 

        $formPersonne->handleRequest($request);

        if($formPersonne->isSubmitted() && $formPersonne->isValid()){

            $em->persist($personne); 
            $em->flush($personne);

            return $this->redirectToRoute('app_personne');
        }

        return $this->render('personne/ajouter.html.twig', [
            'formPersonne'=> $formPersonne->createView(),
        ]);
    }

}
