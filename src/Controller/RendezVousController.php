<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rendez/vous")
 */
class RendezVousController extends AbstractController
{
    /**
     * @Route("/", name="rendez_vous_index", methods={"GET"})
     */
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findByUserAndNotPickedUp($this->getUser()),
        ]);
    }

    /**
     * @Route("/{id_commande}/new", name="rendez_vous_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id_commande, \Swift_Mailer $mailer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findOneById($id_commande);
        if($commande->getUser()->getId() != $this->getUser()->getId()) {
            return $this->redirectToRoute('commande_index');
        }
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $rendezVou->setMagasin($commande->getMagasin());
            $rendezVou->setUser($this->getUser());
            $rendezVou->setCommande($commande);
            $commande->setEtat(3);
            $entityManager->persist($commande);
            $entityManager->persist($rendezVou);
            $entityManager->flush();
            return $this->sendConfirmationEmail($rendezVou,$mailer);
        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendez_vous_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rendez_vous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RendezVous $rendezVou): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendez_vous_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RendezVous $rendezVou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendez_vous_index');
    }

    public function sendConfirmationEmail(RendezVous $rdv, \Swift_Mailer $mailer)
    {
    $message = (new \Swift_Message('Commande confirmée'))
        ->setFrom('usine.swift@gmail.com')
        ->setTo($this->getUser()->getEmail())
        ->setBody(
            $this->renderView(
                'emails/apt_confirmation.html.twig',
                ['jour' => $rdv->getJour(), 'horaire' => $rdv->getHoraire(), 'id_commande' => $rdv->getCommande()->getId()]
            ),
            'text/html'
        );

    $mailer->send($message);

    return $this->redirectToRoute('rendez_vous_index');
}
}
