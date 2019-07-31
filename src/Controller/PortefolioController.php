<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PortefolioController extends AbstractController
{
    /**
     * @Route("/", name="portefolio")
     */
    public function index()
    {
        return $this->render('portefolio/index.html.twig', [
            'controller_name' => 'PortefolioController',
        ]);
    }
}
