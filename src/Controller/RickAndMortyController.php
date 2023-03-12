<?php

namespace App\Controller;

use App\Entity\RickAndMorty;
use App\Entity\Status;
use App\Form\RickAndMortyType;
use App\Manager\RickAndMortyManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use LDAP\Result;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class RickAndMortyController extends AbstractController
{

    #[Route('/rickandmorty/{id}', name:'showRickAndMorty')]
    public function showRickAndMorty(EntityManagerInterface $doctrine, $id)
    {
        $repositorio = $doctrine->getRepository(RickAndMorty::class);
        $rickandmorty = $repositorio->find($id);
        return $this->render('rickandmortys/showRickAndMorty.html.twig', ['rickandmorty' => $rickandmorty]);
    }


    #[Route('/rickandmortys', name: 'listRickAndMorty')]
    public function listRickandMorty(EntityManagerInterface $doctrine)
    {
        $repositorio = $doctrine->getRepository(RickAndMorty::class);
        $rickandmortys = $repositorio->findAll();
        return $this->render('rickandmortys/listRickAndMorty.html.twig', ['rickandmortys' => $rickandmortys]);
    }

    #[Route('/new/rickandmorty')]
    public function newRickAndMorty(EntityManagerInterface $doctrine)
    {
        $rickandmorty1 = new RickAndMorty();
        $rickandmorty1->setNombre("Rick Sanchez");
        $rickandmorty1->setDescripcion("Especie humana");
        $rickandmorty1->setImagen("https://rickandmortyapi.com/api/character/avatar/1.jpeg");
        $rickandmorty1->setCodigo(44);

        $rickandmorty2 = new RickAndMorty();
        $rickandmorty2->setNombre("Johnny Depp");
        $rickandmorty2->setDescripcion("Especie humana");
        $rickandmorty2->setImagen("https://rickandmortyapi.com/api/character/avatar/183.jpeg");
        $rickandmorty2->setCodigo(1);

        $rickandmorty3 = new RickAndMorty();
        $rickandmorty3->setNombre("Morty Smith");
        $rickandmorty3->setDescripcion("Especie humana");
        $rickandmorty3->setImagen("https://rickandmortyapi.com/api/character/avatar/2.jpeg");
        $rickandmorty3->setCodigo(4);

        $status1 = new Status();
        $status1-> setNombre("Vivo");
        
        $status2 = new Status();
        $status2-> setNombre("Muerto");

        $rickandmorty1 -> addStatue($status1);
        $rickandmorty1 -> addStatue($status2);
        $rickandmorty2 -> addStatue($status2);
       

        $doctrine->persist($rickandmorty1);
        $doctrine->persist($rickandmorty2);
        $doctrine->persist($rickandmorty3);

        $doctrine->persist($status1);
        $doctrine->persist($status2);

        $doctrine->flush();
        return new Response("Personajes insertados correctamente");
    }


    #[Route('/insert/rickandmorty', name: 'insertRickAndMorty')]
    public function insertRickAndMorty(Request $request, EntityManagerInterface $doctrine, RickAndMortyManager $manager){

        $form = $this->createForm(RickAndMortyType::class);
        $form-> handleRequest($request);
        if ($form-> isSubmitted() && $form-> isValid()){
            $rickandmorty=$form->getData();
            $rickandmortyImage = $form->get('imagenRickAndMorty')-> getData();
            if ($rickandmortyImage){
                $rickImage = $manager -> load($rickandmortyImage, $this->getParameter
                ('kernel.project_dir').'/public/asset/image' );
                $rickandmorty -> setImagen('/asset/image/' .$rickImage);
            }
            $doctrine-> persist($rickandmorty);
            $doctrine-> flush();
            $this->addFlash('success', 'Personajes insertados correctamente');
            return $this-> redirectToRoute('listRickAndMorty');
        }
        return $this->renderForm('rickandmortys/createRickAndMorty.html.twig', [
            'rickandmortyForm' => $form
        ]);


    }

    #[Route('/edit/rickandmorty/{id}', name: 'editRickAndMorty')]
    public function editRickAndMorty(Request $request, EntityManagerInterface $doctrine , $id){
        $repositorio = $doctrine->getRepository(RickAndMorty::class);
        $rickandmorty = $repositorio->find($id);

        $form = $this->createForm(RickAndMortyType::class, $rickandmorty);
        $form-> handleRequest($request);
        if ($form-> isSubmitted() && $form-> isValid()){
            $rickandmorty=$form->getData();
            $doctrine-> persist($rickandmorty);
            $doctrine-> flush();
            $this->addFlash('success', 'Personajes insertados correctamente');
            return $this-> redirectToRoute('listRickAndMorty');
        }
        return $this->renderForm('rickandmortys/createRickAndMorty.html.twig', [
            'rickandmortyForm' => $form
        ]);
    }

    #[Route('delete/rickandmorty/{id}', name:'deleteRickAndMorty')]
    public function deleteRickAndMorty(EntityManagerInterface $doctrine, $id){
        $repositorio = $doctrine->getRepository(RickAndMorty::class);
        $rickandmorty = $repositorio->find($id);
        $doctrine -> remove($rickandmorty);
        $doctrine -> flush();
        $this->addFlash('success', 'Personaje borrado correctamente');
        return $this->redirectToRoute('listRickAndMorty');
    }
}
