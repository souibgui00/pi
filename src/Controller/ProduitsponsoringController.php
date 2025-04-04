<?php

namespace App\Controller;

use App\Entity\Produitsponsoring;
use App\Form\ProduitsponsoringType;
use App\Repository\ProduitsponsoringRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produitsponsoring')]
final class ProduitsponsoringController extends AbstractController
{
    #[Route(name: 'app_produitsponsoring_index', methods: ['GET'])]
    public function index(ProduitsponsoringRepository $produitsponsoringRepository): Response
    {
        return $this->render('produitsponsoring/index.html.twig', [
            'produitsponsorings' => $produitsponsoringRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produitsponsoring_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produitsponsoring = new Produitsponsoring();
        $form = $this->createForm(ProduitsponsoringType::class, $produitsponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produitsponsoring);
            $entityManager->flush();

            return $this->redirectToRoute('app_produitsponsoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produitsponsoring/new.html.twig', [
            'produitsponsoring' => $produitsponsoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produitsponsoring_show', methods: ['GET'])]
    public function show(Produitsponsoring $produitsponsoring): Response
    {
        return $this->render('produitsponsoring/show.html.twig', [
            'produitsponsoring' => $produitsponsoring,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produitsponsoring_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produitsponsoring $produitsponsoring, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsponsoringType::class, $produitsponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produitsponsoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produitsponsoring/edit.html.twig', [
            'produitsponsoring' => $produitsponsoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produitsponsoring_delete', methods: ['POST'])]
    public function delete(Request $request, Produitsponsoring $produitsponsoring, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produitsponsoring->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($produitsponsoring);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produitsponsoring_index', [], Response::HTTP_SEE_OTHER);
    }
}
