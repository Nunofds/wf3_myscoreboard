<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name:'app_search')]
function index(Request $request, GameRepository $gameRepository): Response
    {
    $word = $request->query->get('search');
    $jeux = $gameRepository->findBySearch($word);

    return $this->render('search/index.html.twig', [
        'games' => $jeux,
        'mot' =>$word,
    ]);
}
}
