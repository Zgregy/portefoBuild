<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Profil;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\Techno;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $profil = new Profil();
        $profil->setFirstname("Greg")
                ->setLastname("Dilon")
                ->setPoste("Développeur WEB")
                ->setAddress("66 rue père sanson")
                ->setZipcode("14000")
                ->setCity("Caen")
                ->setPhone("0667888121")
                ->setEmail("greg.dilon@hotmail.fr")
                ->setCourse("<p class='text-justify lead mb-5'>Titulaire d'un brevet de technicien supérieur en services informatiques aux organisations en option solution logicielle et applications métiers à l'<a href='https://www.aifcc.com' target='_blank'>AIFCC</a> de Caen. j'ai effectué mon BTS en contrat de professionnalisation chez <a href='http://www.prod-eo.com/' target='_blank'>PRODEO</a>.</p>")
                ->setPresentation("<p class='text-justify lead mb-5'>Je m’appelle Greg DILON, j’ai 22 ans, passionné depuis toujours par l’informatique je me suis toujours renseigné sur ce domaine. Je suis dynamique, motivé et très curieux sur les sujets qui m’intéressent. J’aime le développement informatique , les impressions 3D et la réalité virtuelle/réalité augmentée.</p>")
                ->setPassword("cheval");
        $manager->persist($profil);
                
                
            $skill = new Skill();
            $skill->setLogo("Proute")
                    ->setTitle("HTML")
                    ->setDesciption("Langage de base pour la création d'un site WEB")
                    ->setProfil($profil);
            $manager->persist($skill);
            
            $project = new Project();
            $project->setPicture("prouteproute")
                    ->setName("Factory")
                    ->setRealized("Réalisé chez PRODEO")
                    ->setShortDescription("Voici mon doigt")
                    ->setLongDescription("Voici mon doigts qui est un dérivé du doigts au même emplacement sur mon pied plus communement appelé orteille.")
                    ->setProfil($profil);
            $manager->persist($project);
            
                $techno = new Techno();
                $techno->setName("HTML")
                        ->setProject($project);
            $manager->persist($techno);
            

        $manager->flush();
    }
}
