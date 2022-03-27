<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name:'app_test')]
function index(): Response
    {
    return $this->render('test/index.html.twig', [
        'controller_name' => 'TestController',
        'texte' => "le texte que je veux afficher",
    ],
    );
}

/* EXERCICE
Ajouter une route pour le chemin "test/calcul" qui utilise le fichier test/index.html.twig et qui affiche le resultat de 12+7
 */
#[Route('/test/calcul')]
function calcul()
    {
    $a = 12;
    $b = 7;
    return $this->render('test/index.html.twig', [
        'controller_name' => '',
        'texte' => "",
        'calcul' => "La somme de $a + $b = " . $a + $b,
    ],
    );

}

#[Route('/test/salut')]
function salut()
    {
    $prenom = 'John';
    return $this->render('test/salut.html.twig', [
        'prenom' => $prenom,
    ],
    );
}

#[Route('/test/tableau')]
function tableau()
    {
    $tableau = ["bonjour", "je m'appelle", 789, true];
    return $this->render("test/tableau.html.twig", [
        "tableau" => $tableau,
    ]);
}

#[Route("/test/assoc")]
function tab()
    {
    $p = [
        "nom" => "Cérien",
        "prenom" => "jean",
        "age" => 32,
    ];
    return $this->render("test/assoc.html.twig", [
        "personne" => $p,
    ]);
}

#[Route("test/objet")]
function objet()
    {
    $objet = new \stdClass;
    $objet->prenom = "Nordine";
    $objet->nom = "Ateur";
    $objet->age = 40;
    return $this->render("test/assoc.html.twig", [
        "personne" => $objet,
    ]);
}

}
