<?php

namespace App\Controller;

use App\Entity\Aluno;
use App\Form\AlunoType;
use App\Repository\AlunoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/aluno')]
class AlunoController extends AbstractController
{
    #[Route('/', name: 'app_aluno_index', methods: ['GET'])]
    public function index(AlunoRepository $alunoRepository): Response
    {
        return $this->render('aluno/index.html.twig', [
            'alunos' => $alunoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_aluno_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aluno = new Aluno();
        $form = $this->createForm(AlunoType::class, $aluno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aluno);
            $entityManager->flush();

            return $this->redirectToRoute('app_aluno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aluno/new.html.twig', [
            'aluno' => $aluno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aluno_show', methods: ['GET'])]
    public function show(Aluno $aluno): Response
    {
        return $this->render('aluno/show.html.twig', [
            'aluno' => $aluno,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aluno_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aluno $aluno, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlunoType::class, $aluno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_aluno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aluno/edit.html.twig', [
            'aluno' => $aluno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aluno_delete', methods: ['POST'])]
    public function delete(Request $request, Aluno $aluno, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aluno->getId(), $request->request->get('_token'))) {
            $entityManager->remove($aluno);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_aluno_index', [], Response::HTTP_SEE_OTHER);
    }
}
