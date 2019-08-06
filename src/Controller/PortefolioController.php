<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Profil;
use App\Entity\Techno;
use App\Entity\Project;
use App\Form\SkillType;
// use App\Controller\SecurityController;
use App\Form\ProfilType;
use App\Form\ProjectType;
use App\Repository\SkillRepository;
use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function homepageUser(UserInterface $user): Response {
        return $this->render('portefolio/user/home.html.twig');
    }
    
    /**
     * @Route("/portefolio/user/project/new", name="user.project.new")
     */
    public function newProject(UserInterface $user, Request $request): Response {
        $project = new Project();
        $project->setProfil($user);
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
            // if ($form->get('profil')->getData() == $project->getProfil()) {
                $this->em->flush();
                $this->addFlash('success', 'Projet modifié avec succès');
                return $this->redirectToRoute('homePageUser');
            // } else {
            //     $this->addFlash('error', 'Une erreur c\'est produite');
            // }
        }
        dump($project);

        return $this->render('portefolio/user/edit.project.html.twig', [
            'project' => $project,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/portefolio/user/skill/new/", name="user.skill.new")
     */
    public function newSkill(UserInterface $user, Request $request): Response {
        $skill = new Skill();
        // dump($profil);
        // $skill->setProfil($profil);
        $skill->setProfil($user);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($skill);
            $this->em->flush();
            $this->addFlash('success', 'Compétence créée avec succès');
            return $this->redirectToRoute('homePageUser');
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
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->get('_token'))) {
            $this->em->remove($project);
            $this->em->flush();
            $this->addFlash('success', 'Projet supprimé avec succès');
        }
        return $this->redirectToRoute('homePageUser');
    }

    /**
     * @Route("/portefolio/user/setting", name="user.setting")
     */
    public function editProfil(UserInterface $user, Request $request, UserPasswordEncoderInterface $encoder): Response {
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $this->em->flush();
            $this->addFlash('success', 'Profile modifié avec succès');
            return $this->redirectToRoute('homePageUser');
        }

        return $this->render('portefolio/user/setting.html.twig', [
            'profil' => $user,
            'form' => $form->createView()
        ]);
    }
}
