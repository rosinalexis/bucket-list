<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="app_wish",methods={"GET"})
     */
    public function index(WishRepository $repo): Response
    {
        $wishes = $repo->findBy(['isPublished'=>true],['dateCreated'=>'DESC']);
        return $this->render('wish/index.html.twig', compact('wishes'));
    }

    /**
     * @Route("/wish/ajouter", name="app_wish_ajouter",methods={"GET","POST"})
     */
    public function ajouter( EntityManagerInterface $em,Request $request): Response
    {
        $wish = new Wish(); 

        $formWish =  $this->createForm(WishType::class, $wish); 

        $formWish->handleRequest($request);

        if($formWish->isSubmitted() && $formWish->isValid()){

            $em->persist($wish); 
            $em->flush($wish);

            return $this->redirectToRoute('app_wish');
        }

        return $this->render('wish/ajouter.html.twig', [
            'formWish'=> $formWish->createView(),
        ]);

    }

    /**
     * @Route("/wish/{id<[0-9]+>}", name="app_wish_afficher",methods={"GET"})
     */
    public function afficher(Wish $wish): Response
    {
        return $this->render('wish/afficher.html.twig', compact('wish'));
    }

}
