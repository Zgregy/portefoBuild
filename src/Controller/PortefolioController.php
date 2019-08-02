<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
// use App\Controller\SecurityController;
use App\Form\ProjectType;
use App\Form\SkillType;
use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Entity\Profil;
use App\Entity\Skill;
use App\Entity\Project;
use App\Entity\Techno;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PortefolioController extends AbstractController {
    /**
     * @var ProfilRepository
     */
    private $profilRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(ProfilRepository $profilRepository, ProjectRepository $projectRepository, SkillRepository $skillRepository, ObjectManager $em) {
        $this->profilRepository = $profilRepository;
        $this->projectRepository = $projectRepository;
        $this->skillRepository = $skillRepository;
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="portefolio")
     */
    public function index(): Response {
        return $this->render('portefolio/index.html.twig', [
            'controller_name' => 'PortefolioController',
        ]);
    }

    /**
     * @Route("/portefolio/user", name="homePageUser")
     */
    public function homepageUser(): Response {
        // $testing = $this->profilRepository->find(2);
        // return $this->render('portefolio/user/home.html.twig', [
        //     'profil' => $testing,
        // ]);
        return $this->render('portefolio/user/home.html.twig');
    }
    
    /**
     * @Route("/portefolio/user/project/new", name="user.project.new")
     */
    public function newProject(Request $request): Response {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($project);
            $this->em->flush();
            $this->addFlash('success', 'Projet modifié avec succès');
            return $this->redirectToRoute('homePageUser');
        }

        return $this->render('portefolio/user/new.project.html.twig', [
            'project' => $project,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/portefolio/user/project/edit/{id}", name="user.project.edit")
     */
    public function editProject(Project $project, Request $request): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Projet modifié avec succès');
            return $this->redirectToRoute('homePageUser');
        }

        return $this->render('portefolio/user/edit.project.html.twig', [
            'project' => $project,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/portefolio/user/skill/new/", name="user.skill.new")
     */
    public function newSkill(Profil $profil, Request $request): Response {
        $skill = new Skill();
        // dump($profil);
        // $skill->setProfil($profil);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($skill);
            $this->em->flush();
            $this->addFlash('success', 'Compétence créée avec succès');
            // return $this->redirectToRoute('homePageUser');
        }

        return $this->render('portefolio/user/new.skill.html.twig', [
            'skill' => $skill,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/portefolio/user/skill/edit/{id}", name="user.skill.edit")
     */
    public function editSkill(Skill $skill, Request $request): Response {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Compétence modifié avec succès');
            return $this->redirectToRoute('homePageUser');
        }

        return $this->render('portefolio/user/edit.skill.html.twig', [
            'skill' => $skill,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/portefolio/user/skill/delete/{id}", name="user.skill.delete")
     * @param Skill $skill
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteSkill(Skill $skill, Request $request) {
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->get('_token'))) {
            $this->em->remove($skill);
            $this->em->flush();
            $this->addFlash('success', 'Compétence supprimé avec succès');
        }
        return $this->redirectToRoute('homePageUser');
    }
    
    /**
     * @Route("/portefolio/user/project/delete/{id}", name="user.project.delete")
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProject(Project $project, Request $request) {
        // if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->get('_token'))) {
            $this->em->remove($project);
            $this->em->flush();
            $this->addFlash('success', 'Projet supprimé avec succès');
        // }
        return $this->redirectToRoute('homePageUser');
    }
}
