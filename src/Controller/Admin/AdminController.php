<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="acceuil")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @return Response
     * @Route("/t", name="t")
     */
    public function t(): Response
    {
        return $this->render('admin/t.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}
