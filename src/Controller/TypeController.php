<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Type;
use App\Form\TypeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TypeController extends AbstractController
{

    #[Route('/type', name: 'app_type')]
    public function index(TypeRepository $repo, Request $request): Response
    {
        $types = $repo->findAll();



        return $this->render('type/index.html.twig', [
            'types' => $types
        ]);
    }

    #[Route('/type/{id}',  name: 'app_type_show', requirements: ['id' => '\d+'])]
    public function show(TypeRepository $repo, Request $request, $id): Response
    {
        $type = new Type();
        if (!($type = $repo->findOneBy(['id' => $id]))) {
            return new Response('le personnage n\'existe pas');
        }



        return $this->render('type/show.html.twig', [
            'type' => $type
        ]);
    }


    #[Route('/type/new', name: 'app_type_add')]
    public function add(TypeRepository $repo, Request $request): Response
    {
        $type = new Type();

        $form = $this->createForm(TypeType::class, $type);
        $form->add('Creer', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repo->save($type, true);
            return $this->redirectToRoute('app_type');
        }

        return $this->render('type/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/type/delete/{id}',  name: 'app_type_remove', requirements: ['id' => '\d+'])]
    public function remove(TypeRepository $repo, Request $request, $id): Response
    {
        $type = new Type;

        if ($type = $repo->findOneBy(['id' =>  $id])) {
            $form = $this->createForm(TypeType::class, $type);
            $form->add('valider_la_supression', SubmitType::class);
        } else {
            return new Response('l\'id n\'éxiste pas');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $repo->remove($type, true);
            return $this->redirectToRoute('app_type');
        }




        return $this->render('type/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/type/edit/{id}',  name: 'app_type_edit', requirements: ['id' => '\d+'])]
    public function edit(TypeRepository $repo, Request $request, $id): Response
    {
        $type = new Type;

        //si l'id de personnage existe, créer le formulaire, sinon redirige vers page d'erreuer
        if ($type = $repo->findOneBy(['id' =>  $id])) {
            $form = $this->createForm(TypeType::class, $type);
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
            return $this->redirectToRoute('app_type_show', array('id' => $id));
        } elseif ($form->get('validate')->isClicked() && $form->isValid()) {
            $repo->save($type, true);
            return $this->redirectToRoute('app_type_show', array('id' => $id));
        }




        return $this->render('type/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
