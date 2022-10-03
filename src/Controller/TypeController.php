<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\CharacterRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

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
    public function remove(TypeRepository $repoType,CharacterRepository $repoCharacter, Request $request, $id): Response
    {
        $type = new Type;

        if ($type = $repoType->findOneBy(['id' =>  $id])) {
            //verifier que le type n'est lié à aucun personnage

            $listCharacter = $repoCharacter->findBy(['Type' => $id]);
            $length = count($listCharacter);
            $list = "";
            foreach ($listCharacter as $c){
                $list = $list . $c->getName() . ", "; 
            }

            if ($length > 0){
                return $this->render('error.html.twig',[
                    'message' =>  $length . ' personnage(s) sont liés à cette classe : ' .  $list  . ' supprimez le(s) personnage(s) avant de pouvoir supprimer la classe',
                    'url' => '/type',
                    'urlname' => 'Classes'
                ]);
            }else{
                $repoType->remove($type, true);
            }
        } else {
            return $this->render('error.html.twig', [
                'message' => 'l\'id n\'existe pas',
                'url' => '/type',
                'urlname' => 'Retour à la page des Classes'
            ]);
        }

        return $this->redirectToRoute('app_type');
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
                'url' => "/type",
                'urlname' => 'Retour à la page des Classes'
            ]);
        }

        $form->handleRequest($request);

        //test les bouttons cliqué
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('app_type', array('id' => $id));
        } elseif ($form->get('validate')->isClicked() && $form->isValid()) {
            $repo->save($type, true);
            return $this->redirectToRoute('app_type', array('id' => $id));
        }




        return $this->render('type/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
