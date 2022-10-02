<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class CharacterController extends AbstractController
{

/*
	#[Route($this->getParameter('ProfilePicture_directory') . '{fileName}'  )]
	public function getMedia($fileName){
		$filesystem = new Filesystem();
		$filesystem->get
		return 
	}*/

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
            return $this->render('error.html.twig',[
                'message' => 'Le personnage n\'existe pas',
                'url' => '/',
                'urlname' => 'page d\'accueil'
            ]);
        }

        //$package = new Package(new EmptyVersionStrategy());

            // Absolute path
            //echo $package->getUrl('/image.png');
            // result: /image.png

            // Relative path 
            //echo $package->getUrl($character->getProfilPicture());
            // result: image.png

          //  $profilePicturePath =   $this->getParameter('ProfilePicture_directory'); // . "/" .  $character->getProfilPicture() ;

        return $this->render('character/show.html.twig', [
            'character' => $character
           // 'profilPicture' => $profilePicturePath
        ]);
    }


    #[Route('/character/new', name: 'app_character_add')]
    public function add(CharacterRepository $repo, Request $request, SluggerInterface $slugger): Response
    {
        $character = new Character();

        $form = $this->createForm(CharacterType::class, $character);
        $form->add('Creer', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($character->getType() == null) {
                return $this->render('error.html.twig', [
                    'message' => 'Aucun type n\'a été attribué, peut-être qu\'aucun type n\'a encore été créé',
                    "url" => '/type',
                    'urlname' => 'Afficher les types'
                ]);
            } else {
                $profilePictureFile =  $form->get('profilPicture')->getData();

                if ($profilePictureFile) {

                    $originaleFilename = pathinfo($profilePictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originaleFilename);
                    $newFileName = $safeFilename . '-' . uniqid() . '.' . $profilePictureFile->guessExtension();

                    try {
                        $profilePictureFile->move($this->getParameter('ProfilePicture_directory'), $newFileName);
                    } catch (FileException $e) {
                        return $this->render('error.html.twig', [
                            'message' => 'Une erreur est survenue pendant l\'upload de l\'image',
                            'url' => '/character/new',
                            'urlname' => 'réessayer'
                        ]);
                    }
                    $character->setProfilPicture($newFileName);

                    
                }
                $repo->save($character, true);
                return $this->redirectToRoute('home_page');
            }
        }

        return $this->render('character/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/character/delete/{id}',  name: 'app_character_remove', requirements: ['id' => '\d+'])]
    public function remove(CharacterRepository $repo, Request $request, $id): Response
    {
       // $character = new Character;

        if ($character = $repo->findOneBy(['id' =>  $id])) {
           // $form = $this->createForm(CharacterType::class, $character);
           // $form->add('valider_la_supression', SubmitType::class);
           $filesystem = new Filesystem();

           try{
                $filesystem->remove($this->getParameter('ProfilePicture_directory') . '/' . $character->getProfilPicture());

                $repo->remove($character, true);
        return $this->redirectToRoute('home_page');

           }catch (IOExceptionInterface $e){
            echo "Une erreur est survenue lors de la suppression de l'image de profil : " . $e->getPath();

           }

           
        } else {
            return $this->render('error.html.twig',[
                'message' => 'le personnage n\'existe pas',
                'url' => '/',
                'urlname' => 'Page d\'accueil'
            ]);
        }

    }

    #[Route('/character/edit/{id}',  name: 'app_character_edit', requirements: ['id' => '\d+'])]
    public function edit(CharacterRepository $repo, Request $request, $id, SluggerInterface $slugger): Response
    {
        $character = new Character;

        //si l'id de personnage existe, créer le formulaire, sinon redirige vers page d'erreur
        if ($character = $repo->findOneBy(['id' =>  $id])) {
            $oldProfilPicture = $character->getProfilPicture();
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



            $profilePictureFile =  $form->get('profilPicture')->getData();

                if ($profilePictureFile) {

                    $originaleFilename = pathinfo($profilePictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originaleFilename);
                    $newFileName = $safeFilename . '-' . uniqid() . '.' . $profilePictureFile->guessExtension();

                    try {
						$filesystem = new Filesystem();

                        $profilePictureFile->move($this->getParameter('ProfilePicture_directory'), $newFileName);
						$filesystem->remove($this->getParameter('ProfilePicture_directory') . '/' . $oldProfilPicture);

                    } catch (FileException $e) {
                        return $this->render('error.html.twig', [
                            'message' => 'Une erreur est survenue pendant l\'upload de l\'image',
                            'url' => '/character/new',
                            'urlname' => 'réessayer'
                        ]);
                    }
                    $character->setProfilPicture($newFileName);

					$repo->save($character, true);
					return $this->redirectToRoute('app_character_show', array('id' => $id));
				}

		}
		return $this->render('character/delete.html.twig', [
			'form' => $form->createView()
		]);
}
}
