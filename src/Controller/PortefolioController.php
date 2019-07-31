<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\ProfilRepository;
use App\Entity\Profil;
use App\Entity\Skill;
use App\Entity\Project;
use App\Entity\Techno;

class PortefolioController extends AbstractController {
    /**
     *
     * @var ProfilRepository
     */
    private $repository;

    public function __construct(ProfilRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/", name="portefolio")
     */
    public function index(): Response {
        $testing = $this->repository->find(1);
        dump($testing);
        return $this->render('portefolio/index.html.twig', [
            'controller_name' => 'PortefolioController',
        ]);
    }

    /**
     * @Route("/portefolio/user", name="test")
     */
    public function homepageUser(): Response {
        $testing = $this->repository->find(1);
        return $this->render('portefolio/user/home.html.twig', [
            'profil' => $testing,
        ]);
    }
}
