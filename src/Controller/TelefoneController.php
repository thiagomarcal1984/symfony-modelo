<?php

namespace App\Controller;

use App\Entity\Telefone;
use App\Form\TelefoneType;
use App\Repository\TelefoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/telefone')]
class TelefoneController extends AbstractController
{
    #[Route('/', name: 'app_telefone_index', methods: ['GET'])]
    public function index(TelefoneRepository $telefoneRepository): Response
    {
        return $this->render('telefone/index.html.twig', [
            'telefones' => $telefoneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_telefone_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $telefone = new Telefone();
        $form = $this->createForm(TelefoneType::class, $telefone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($telefone);
            $entityManager->flush();

            return $this->redirectToRoute('app_telefone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('telefone/new.html.twig', [
            'telefone' => $telefone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_telefone_show', methods: ['GET'])]
    public function show(Telefone $telefone): Response
    {
        return $this->render('telefone/show.html.twig', [
            'telefone' => $telefone,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_telefone_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Telefone $telefone, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TelefoneType::class, $telefone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_telefone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('telefone/edit.html.twig', [
            'telefone' => $telefone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_telefone_delete', methods: ['POST'])]
    public function delete(Request $request, Telefone $telefone, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$telefone->getId(), $request->request->get('_token'))) {
            $entityManager->remove($telefone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_telefone_index', [], Response::HTTP_SEE_OTHER);
    }
}
