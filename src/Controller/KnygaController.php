<?php

namespace App\Controller;

use App\Entity\Knyga;
use App\Form\KnygaForm;
use App\Repository\KnygaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/knyga')]
final class KnygaController extends AbstractController
{
    #[Route(name: 'app_knyga_index', methods: ['GET'])]
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

    #[Route('/new', name: 'app_knyga_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $knyga = new Knyga();
        $form = $this->createForm(KnygaForm::class, $knyga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($knyga);
            $entityManager->flush();

            $this->addFlash('success', 'Knyga pridėta sėkmingai');

            return $this->redirectToRoute('app_knyga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('knyga/new.html.twig', [
            'knyga' => $knyga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_knyga_show', methods: ['GET'])]
    public function show(Knyga $knyga): Response
    {
        return $this->render('knyga/show.html.twig', [
            'knyga' => $knyga,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_knyga_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Knyga $knyga, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(KnygaForm::class, $knyga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_knyga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('knyga/edit.html.twig', [
            'knyga' => $knyga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_knyga_delete', methods: ['POST'])]
    public function delete(Request $request, Knyga $knyga, EntityManagerInterface $entityManager): Response
    {
        $request->request->get('_token'); 
            $entityManager->remove($knyga);
            $entityManager->flush();
        
        $this->addFlash('danger', 'Knyga ištrinta');
        return $this->redirectToRoute('app_knyga_index', [], Response::HTTP_SEE_OTHER);
    }
}
