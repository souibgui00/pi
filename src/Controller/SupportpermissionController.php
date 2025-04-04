<?php

namespace App\Controller;

use App\Entity\Supportpermission;
use App\Form\SupportpermissionType;
use App\Repository\SupportpermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/supportpermission')]
final class SupportpermissionController extends AbstractController
{
    #[Route(name: 'app_supportpermission_index', methods: ['GET'])]
    public function index(SupportpermissionRepository $supportpermissionRepository): Response
    {
        return $this->render('supportpermission/index.html.twig', [
            'supportpermissions' => $supportpermissionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_supportpermission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supportpermission = new Supportpermission();
        $form = $this->createForm(SupportpermissionType::class, $supportpermission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supportpermission);
            $entityManager->flush();

            return $this->redirectToRoute('app_supportpermission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('supportpermission/new.html.twig', [
            'supportpermission' => $supportpermission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_supportpermission_show', methods: ['GET'])]
    public function show(Supportpermission $supportpermission): Response
    {
        return $this->render('supportpermission/show.html.twig', [
            'supportpermission' => $supportpermission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_supportpermission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Supportpermission $supportpermission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupportpermissionType::class, $supportpermission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_supportpermission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('supportpermission/edit.html.twig', [
            'supportpermission' => $supportpermission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_supportpermission_delete', methods: ['POST'])]
    public function delete(Request $request, Supportpermission $supportpermission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supportpermission->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($supportpermission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_supportpermission_index', [], Response::HTTP_SEE_OTHER);
    }
}
