<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/admin/game', name:'app_admin_game')]
function index(GameRepository $gameRepository): Response
    {
    /*
    On ne PEUT PAS instancier d'objets d'une classe Repository
    on doit les passer dans les arguments d'une méthode d'un contrôleur
    NB : pour chaque classe Entity créée, il y a une classe Repository
    qui correspond et qui permet de faire des requêtes SELECT sur la
    table correspondante
     */

    // $gameRepository = new GameRepository;
    return $this->render('admin/game/index.html.twig', [
        "games" => $gameRepository->findAll(),

    ]);
}

#[Route('/admin/game/new', name:'app_admin_game_new')]
function new (Request $request, EntityManagerInterface $em) {
    /*  * La classe Request permet d'instancier un objet qui contient
     * toutes les valeurs des variables super-globales de PHP.
     * Ces valeurs sont dans des propriétés (qui sont des objets).
     *  $request->query      contient        $_GET
     *  $request->request    contient        $_POST
     *  $request->server     contient        $SERVER
     * ...
     *  Pour accéder aux valeurs, on utilisera sur ces propriétés la
     *  méthode ->get('indice')
     *
     *  La classe EntityMangager va permettre d'exécuter les requêtes
     *  qui modifient les données (INSERT, UPDATE, DELETE).
     *  L'EntityManager va toujours utiliser des objets Entity pour
     *  modifier les données.
     */

    // dump($request);
    $jeu = new Game;
    // dump($jeu);

    $form = $this->createForm(GameType::class, $jeu);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // la méthode persist() prépare le requete INSERT avec les données de l'objet passé en argument
        $em->persist($jeu);
        // la méthode flush() exécute les requetes en attente et donc modifie la bdd
        $em->flush();

        return $this->redirectToRoute("app_admin_game");
    }

    return $this->render('admin/game/form.html.twig', [
        "formGame" => $form->createView(),
    ]);
}

#[Route('/admin/game/edit{id}', name:'app_admin_game_edit')]
function edit(Request $rq, EntityManagerInterface $em, GameRepository $gameRepository, $id)
    {

    $jeu = $gameRepository->find($id);
    $form = $this->createForm(GameType::class, $jeu);
    $form->handleRequest($rq);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute("app_admin_game");

    }

    return $this->render('admin/game/form.html.twig', [
        "formGame" => $form->createView(),
    ]);
}

    #[Route('/admin/game/modifier/{title}', name:'app_admin_game_modifier')]
    public function modifier(Request $rq, EntityManagerInterface $em, Game $jeu)
    {
        //$jeu = $gameRepository->find($id); //ca on en a plus besoin
        $form = $this->createForm(GameType::class, $jeu);

        $form->handleRequest($rq); //handleRequest important
        if($form->isSubmitted()&& $form->isValid()){
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }

        return $this->render("admin/game/form.html.twig",["formGame"=>$form->createView() ]);
    }

/**
 * EXO
 *  1 .créer une route app_admin_game_delete, qui prend l'id comme paramètre
 *  2. afficher les informations du jeu à supprimer avec une nouvelle vue
 *         Confirmation de suppression du jeu suivant :
 *              . titre
 *              . Entre nb_min et nb_max joueurs
 *
 */
#[Route('/admin/game/delete{id}', name:'app_admin_game_delete')]
function delete(GameRepository $gameRepository, Request $rq, EntityManagerInterface $em, $id)
    {

    $jeu = $gameRepository->find($id);

    if ($rq->isMethod('POST')) {
        $em->remove($jeu);
        $em->flush();
        return $this->redirectToRoute('app_admin_game');
    }

    return $this->render('admin/game/delete.hmtl.twig', [
        "game2" => $jeu,
    ]);

}

/*
 ******************** A supprimer COURS CESAIRE ********************
 */
//     #[Route('/admin/game', name:'app_admin_game')]
// #[Route('/admin/show/{id}', name:'show')]
// function index(GameRepository $gameRepository, PlayerRepository $playerRepository, $id = null): Response
//     {

//     $players = $playerRepository->findAll();
//     // dump($players);
//     // dd($players);

//     if ($id):
//         $player = $playerRepository->find($id);
//     else:
//         $player = false;
//     endif;

//     return $this->render('admin/game/index.html.twig', [
//         "games" => $gameRepository->findAll(),
//         "players" => $players,
//         "player" => $player,

//     ]);
// }

}
