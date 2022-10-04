<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SkillRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Skill;
use App\Form\SkillType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillController extends AbstractController
{

    #[Route('/skill', name: 'app_skill')]
    public function index(SkillRepository $repo, Request $request): Response
    {
        $skills = $repo->findAll();



        return $this->render('skill/index.html.twig', [
            'skills' => $skills
        ]);
    }

 

    #[Route('/skill/new', name: 'app_skill_add')]
    public function add(SkillRepository $repo, Request $request): Response
    {
        $skill = new Skill();

        $form = $this->createForm(SkillType::class, $skill);
        $form->add('Creer', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repo->save($skill, true);
            return $this->redirectToRoute('app_skill');
        }

        return $this->render('skill/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/skill/delete/{id}',  name: 'app_skill_remove', requirements: ['id' => '\d+'])]
    public function remove(SkillRepository $repo, Request $request, $id): Response
    {
        $skill = new Skill;

        if ($skill = $repo->findOneBy(['id' =>  $id])) {
            $repo->remove($skill, true);
        } else {
            return $this->render('error.html.twig', [
                'message' => 'l\'id n\'existe pas',
                'url' => '/skill',
                'urlname' => 'Retour à la page compétences'
            ]);
        }

        return $this->redirectToRoute('app_skill');
    }



    #[Route('/skill/edit/{id}',  name: 'app_skill_edit', requirements: ['id' => '\d+'])]
    public function edit(SkillRepository $repo, Request $request, $id): Response
    {
        $skill = new Skill;

        //si l'id de personnage existe, créer le formulaire, sinon redirige vers page d'erreuer
        if ($skill = $repo->findOneBy(['id' =>  $id])) {
            $form = $this->createForm(SkillType::class, $skill);
            $form->add('validate', SubmitType::class);
            $form->add('cancel', SubmitType::class);
        } else {
            return $this->render('error.html.twig', [
                'message' => 'l\'id n\'existe pas',
                'url' => '/skill',
                'urlname' => 'Retour à la page compétences'
            ]);
        }

        $form->handleRequest($request);

        //test les bouttons cliqué
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('app_skill', array('id' => $id));
        } elseif ($form->get('validate')->isClicked() && $form->isValid()) {
            $repo->save($skill, true);
            return $this->redirectToRoute('app_skill', array('id' => $id));
        }




        return $this->render('skill/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
