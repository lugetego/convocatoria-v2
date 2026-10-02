<?php

namespace App\Controller;

use App\Form\EvalType;
use App\Repository\RegistroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->redirectToRoute('registro_index');
    }

    #[Route('/{id}/eval', name: 'form_eval', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function eval(Request $request, EntityManagerInterface $entityManager, RegistroRepository $registroRepository, int $id): Response
    {
        $registro = $registroRepository->find($id);
        if (null === $registro) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(EvalType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($registro);
            $entityManager->flush();

            return $this->redirectToRoute('registro_show', ['id' => $id]);
        }

        return $this->render('admin/eval.html.twig', [
            'form' => $form->createView(),
            'registro' => $registro,
        ]);
    }

    #[Route('/consulta', name: 'registro_cv', methods: ['GET'])]
    public function consulta(RegistroRepository $registroRepository): Response
    {
        return $this->render('registro/consulta.html.twig', [
            'registros' => $registroRepository->findAll(),
        ]);
    }
}
