<?php

namespace App\Controller;

use App\Repository\OeuvreRepository;
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

}
