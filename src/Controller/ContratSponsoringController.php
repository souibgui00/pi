<?php

namespace App\Controller;

use App\Entity\ContratSponsoring;
use App\Form\ContratSponsoringType;
use App\Repository\ContratSponsoringRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrat/sponsoring')]
final class ContratSponsoringController extends AbstractController
{
    #[Route(name: 'app_contrat_sponsoring_index', methods: ['GET'])]
    public function index(ContratSponsoringRepository $contratSponsoringRepository): Response
    {
        return $this->render('contrat_sponsoring/index.html.twig', [
            'contrat_sponsorings' => $contratSponsoringRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contrat_sponsoring_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contratSponsoring = new ContratSponsoring();
        $form = $this->createForm(ContratSponsoringType::class, $contratSponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contratSponsoring);
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_sponsoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat_sponsoring/new.html.twig', [
            'contrat_sponsoring' => $contratSponsoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_sponsoring_show', methods: ['GET'])]
    public function show(ContratSponsoring $contratSponsoring): Response
    {
        return $this->render('contrat_sponsoring/show.html.twig', [
            'contrat_sponsoring' => $contratSponsoring,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrat_sponsoring_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContratSponsoring $contratSponsoring, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratSponsoringType::class, $contratSponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_sponsoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat_sponsoring/edit.html.twig', [
            'contrat_sponsoring' => $contratSponsoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_sponsoring_delete', methods: ['POST'])]
    public function delete(Request $request, ContratSponsoring $contratSponsoring, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contratSponsoring->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contratSponsoring);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contrat_sponsoring_index', [], Response::HTTP_SEE_OTHER);
    }
}
