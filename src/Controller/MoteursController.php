<?php

namespace App\Controller;

use App\Entity\Moteurs;
use App\Form\MoteursType;
use App\Repository\MoteursRepository;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/moteurs')]
class MoteursController extends AbstractController
{
    #[Route('/', name: 'moteur.index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(MoteursRepository $moteursRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $moteurs = $paginator->paginate(
            $moteursRepository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/moteurs/index.html.twig', [
            'moteurs' => $moteurs
        ]);
    }

    #[Route('/new', name: 'moteur.new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $moteur = new Moteurs();
        $form = $this->createForm(MoteursType::class, $moteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moteur->setUser($this->getUser());
            $entityManager->persist($moteur);
            $entityManager->flush();

            $this->addFlash('success', 'Votre moteur a été créé avec succès !');

            return $this->redirectToRoute('moteur.index');
        }

        return $this->render('pages/moteurs/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/edit/{id}', name: 'moteur.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Moteurs $moteur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MoteursType::class, $moteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre moteur a été modifié avec succès !'
            );

            return $this->redirectToRoute('moteur.index');
        }

        return $this->render('pages/moteurs/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'moteur.delete', methods: ['GET', 'POST'])]
    
        // Votre code de suppression ici
    
        #[IsGranted('ROLE_USER')]
        public function delete(Request $request, Moteurs $moteur, EntityManagerInterface $entityManager): Response
        {
        if ($this->isCsrfTokenValid('delete' . $moteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($moteur);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre moteur a été supprimé avec succès !'
            );
        }

        return $this->redirectToRoute('moteur.index');
    }
}
