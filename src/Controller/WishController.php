<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="app_wish")
     */
    public function index(WishRepository $repo): Response
    {
        $wishes = $repo->findAll();
        return $this->render('wish/index.html.twig', compact('wishes'));
    }

    /**
     * @Route("/wish/ajouter", name="app_wish_ajouter")
     */
    public function ajouter( EntityManagerInterface $em): Response
    {
        $wish = new Wish(); 
        $wish->setTitle('test')
        ->setDescription('description de test')
        ->setAuthor('testeur')
        ->setIsPublished(1)
        ->setDateCreated(new \DateTimeImmutable);
       
        $em->persist($wish); 
        $em->flush($wish);

        return $this->redirectToRoute('app_wish');
    }

        /**
     * @Route("/wish/{id<[0-9]+>}", name="app_wish_afficher")
     */
    public function afficher(Wish $wish): Response
    {
        return $this->render('wish/afficher.html.twig', compact('wish'));
    }

}
