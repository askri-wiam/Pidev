<?php

namespace App\Controller\Visiteur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiteurController extends AbstractController
{
    /**
     * @Route("/", name="visiteur")
     */
    public function index(): Response
    {
        return $this->render('visiteur/index.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('visiteur/contact.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }
}
