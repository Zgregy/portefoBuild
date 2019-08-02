<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

// use App\Controller\PortefolioController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $profil = new Profil();

        $form = $this->createForm(ProfilType::class, $profil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($profil, $profil->getPassword());

            $profil->setPassword($hash);

            $manager->persist($profil);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }
    
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {}
}
