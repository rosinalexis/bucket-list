<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\CategoryRepository;
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
     * @Route("admin/wish/modifier/{id<[0-9]+>}", name="app_wish_modifier",methods={"GET","POST"})
     * 
     */
    public function traitement(Wish $wish =null,EntityManagerInterface $em,Request $request): Response
    {
        if($wish ==null){
            $wish = new Wish(); 
        }
        $formWish =  $this->createForm(WishType::class, $wish); 

        $formWish->handleRequest($request);

        if($formWish->isSubmitted() && $formWish->isValid()){
           
            if($wish->getId() ==null)
            {
                $wish->setIsPublished(true); 
                $wish->setDateCreated(new \DateTimeImmutable());
                
                if($formWish->get('majeur')->getData() == true){
                    $em->persist($wish); 
                    $em->flush();
                }
            }
            else{
                $em->persist($wish); 
                $em->flush();
            }
            return $this->redirectToRoute('app_wish');
        }

        return $this->render('wish/traitement.html.twig', [
            'formWish'=> $formWish->createView(),
            'editMode'=>$wish->getId() !==null
        ]);
    }


    /**
     * @Route("admin/wish/ajoute", name="app_wish_ajouter_rapide",methods={"POST"})
     * 
     */
    public function ajouterRapide(EntityManagerInterface $em,CategoryRepository $catRepo,Request $request): Response
    {
        $titre =$request->request->get('titre');

        $wish = new Wish(); 
        $category = new Category(); 
        $category =$catRepo->findOneBy(['id'=>'5']);

        //valeur par defaut
        $wish->setTitle($titre);
        $wish->setCategory($category);
        $wish->setAuthor('admin'); 
        $wish->setIsPublished(true); 
        $wish->setDateCreated(new \DateTimeImmutable());
        
        $em->persist($wish); 
        $em->flush();
        return $this->redirectToRoute('admin_home');
    }


    /**
     * @Route("/wish/afficher/{id<[0-9]+>}", name="app_wish_afficher",methods={"GET"})
     */
    public function afficher(Wish $wish): Response
    {
        return $this->render('wish/afficher.html.twig', compact('wish'));
    }

    
    /**
     * @Route("admin/wish/supprimer/{id<[0-9]+>}", name="app_wish_supprimer",methods={"GET","POST"})
     */
    public function supprimer(Wish $wish,EntityManagerInterface $em): Response
    {
        $em->remove($wish); 
        $em->flush();
        return $this->redirectToRoute('admin_home');
    }


}
