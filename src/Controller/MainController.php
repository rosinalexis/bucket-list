<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/main", name="app_main")
     */
    public function index(): Response
    {
        $personnes[0]["nom"] = "Willis";
        $personnes[0]["prenom"] = "Bruce";
        $personnes[1]["nom"] = "PITT";
        $personnes[1]["prenom"] = "Brad";
        $personnes[2]["nom"] = "CRUISE";
        $personnes[2]["prenom"] = "Tom";

        return $this->render('main/index.html.twig',
    ['personnes' =>$personnes]);
    }

    /**
     * @Route("/dino", name="app_dino")
     */
    public function dino(): Response
    {
        return $this->render('main/dino.html.twig');
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }

}
