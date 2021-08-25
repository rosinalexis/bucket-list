<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function ajouter(EntityManagerInterface $em):Response
    {
        //Enity Manager
        $personne = new Personne();
        $personne->setNom('doe')
                ->setPrenom('jack')
                ->setAge(12);

        $em->persist($personne);
        $em->flush($personne);

        return $this->redirectToRoute('app_personne');
    }

}
