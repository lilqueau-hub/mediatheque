<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Form\OeuvreType;
use App\Repository\OeuvreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OeuvreController extends AbstractController
{
    #[Route('/oeuvre', name: 'app_oeuvre')]
    public function index(OeuvreRepository $oeuvreRepository): Response
    {
        // récuperer toutes les oeuvres de la bdd
        $oeuvres = $oeuvreRepository->findAll();

        return $this->render('oeuvre/index.html.twig', [
            'oeuvres' => $oeuvres,
        ]);
    }

    #[Route('/oeuvre/recherche', name: 'oeuvre_recherche')]
    public function recherche(OeuvreRepository $oeuvreRepository, Request $request): Response
    {
        $titre = $request->query->get('titre');

        $oeuvresTrouve = [];

        if ($titre) {
            $oeuvresTrouve = $oeuvreRepository->rechercheParTitre($titre);
        }

        return $this->render('oeuvre/recherche.html.twig', [
            'oeuvres' => $oeuvresTrouve,
            'titre' => $titre
        ]);
    }

    #[Route('/oeuvre/{id}', name: 'oeuvre_detail', requirements: ['id' => '\d+'])]
    public function afficherDetails(int $id, OeuvreRepository $oeuvreRepository): Response
    {
        $oeuvre = $oeuvreRepository->find($id);

        if(!$oeuvre) {
            throw $this->createNotFoundException('oeuvre introuvable');
        }

        return $this->render('oeuvre/oeuvreDetails.html.twig', [
            'oeuvre' => $oeuvre
        ]);
    }
    
    #[Route('/oeuvre/ajouter', name: 'oeuvre_ajout')]
    public function ajouterOeuvre(Request $request, EntityManagerInterface $em) : Response
    {
        $oeuvre = new Oeuvre();

        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($oeuvre);
            $em->flush();

            return $this->redirectToRoute('app_oeuvre');
        }

        return $this->render('oeuvre/ajouterOeuvre.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/oeuvre/{id}/modifier', name: 'oeuvre_modification', requirements: ['id' => '\d+'])]
    public function modifierOeuvre(int $id, Request $request, EntityManagerInterface $em, OeuvreRepository $oeuvreRepository): Response
    {
        
    }
}
