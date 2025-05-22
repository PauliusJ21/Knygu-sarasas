<?php

namespace App\Controller;

use App\Repository\KnygaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(KnygaRepository $knygaRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $knygaRepository->createQueryBuilder('k')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('knyga/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}

