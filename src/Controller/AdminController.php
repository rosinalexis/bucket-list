<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(WishRepository $repo): Response
    {
        $wishes = $repo->findBy(['isPublished'=>true],['dateCreated'=>'DESC']);
        return $this->render('admin/index.html.twig',compact('wishes'));
    }

     

}
