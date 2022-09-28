<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CharacterController extends AbstractController
{


    #[Route('/', name: 'home_page')]
    public function home(CharacterRepository $repo, Request $request): Response
    {
        $characters = $repo->findAll();

        return $this->render('index.html.twig', [
            'characters' => $characters
        ]);
    }

    /*
    #[Route('/character', name: 'app_character')]
    public function index(CharacterRepository $repo, Request $request): Response
    {
        $characters = $repo->findAll();

        return $this->render('character/index.html.twig', [
            'characters' => $characters
        ]);
    }*/

    #[Route('/character/{id}',  name: 'app_character_show', requirements: ['id' => '\d+'])]
    public function show(CharacterRepository $repo, Request $request, $id): Response
    {
        $character = new Character();
        if (!($character = $repo->findOneBy(['id' => $id]))) {
            return new Response('le personnage n\'existe pas');
        }



        return $this->render('character/show.html.twig', [
            'character' => $character
        ]);
    }


    #[Route('/character/new', name: 'app_character_add')]
    public function add(CharacterRepository $repo, Request $request): Response
    {
        $character = new Character();

        $form = $this->createForm(CharacterType::class, $character);
        $form->add('Creer', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repo->save($character, true);
            return $this->redirectToRoute('home_page');
        }

        return $this->render('character/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/character/delete/{id}',  name: 'app_character_remove', requirements: ['id' => '\d+'])]
    public function remove(CharacterRepository $repo, Request $request, $id): Response
    {
        $character = new Character;

        if ($character = $repo->findOneBy(['id' =>  $id])) {
            $form = $this->createForm(CharacterType::class, $character);
            $form->add('valider_la_supression', SubmitType::class);
        } else {
            return new Response('l\'id n\'éxiste pas');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $repo->remove($character, true);
            return $this->redirectToRoute('home_page');
        }




        return $this->render('character/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/character/edit/{id}',  name: 'app_character_edit', requirements: ['id' => '\d+'])]
    public function edit(CharacterRepository $repo, Request $request, $id): Response
    {
        $character = new Character;

        //si l'id de personnage existe, créer le formulaire, sinon redirige vers page d'erreuer
        if ($character = $repo->findOneBy(['id' =>  $id])) {
            $form = $this->createForm(CharacterType::class, $character);
            $form->add('validate', SubmitType::class);
            $form->add('cancel', SubmitType::class);
        } else {
            return $this->render('error.html.twig', [
                'message' => "l'id n'éxiste pas",
                'url' => "/"
            ]);
        }

        $form->handleRequest($request);

        //test les bouttons cliqué
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('app_character_show', array('id' => $id));
        } elseif ($form->get('validate')->isClicked() && $form->isValid()) {
            $repo->save($character, true);
            return $this->redirectToRoute('app_character_show', array('id' => $id));
        }




        return $this->render('character/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
