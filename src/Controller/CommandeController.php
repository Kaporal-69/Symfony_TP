<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\Magasin;
use App\Entity\Product;
use App\Entity\Stock;
use App\Entity\User;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        $user = $this->security->getUser();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findByUser($user),
        ]);
    }

    /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

     /**
     * @Route("/add_line", name="commande_add_line", methods={"GET","POST"})
     */
    public function addLine(Request $request): Response
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findCurrentCommandeByUser($data['user']);
        if(!$commande) {
            $commande = new Commande();
            $commande->setUser($em->getRepository(User::class)->findOneById($data['user']));
            $commande->setPrixTotal(0);
            $commande->setEtat(1);
            $commande->setMagasin($em->getRepository(Magasin::class)->findOneById($data["shop"]));
            $em->persist($commande);
        }
        $produit = $em->getRepository(Product::class)->findOneById($data['product']);
        $newLine = new LigneCommande();
        $newLine->setCommande($commande);
        $newLine->setQuantite($data['quantite_produit']);
        $newLine->setProduct($produit);
        $stock = $em->getRepository(Stock::class)->findOneBy(["magasin" => $data["shop"],"product" => $data["product"]]);
        $newLine->setPrixTotal($stock->getPrix() * $data['quantite_produit']);
        $em->persist($newLine);
        $em->flush();
        $commande->setPrixTotal($newLine->getPrixTotal() + $commande->getPrixTotal());
        $em->persist($commande);
        $em->flush();
        return $this->redirectToRoute('commande_index');
    }

    /**
     * @Route("/{id}/validate", name="commande_validate", methods={"GET","POST"})
     */
    public function validateOrder(Request $request, Commande $commande): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commande->setEtat(2);
        $em->persist($commande);
        $em->flush();
        return $this->redirectToRoute('rendez_vous_new', array('id_commande' => $commande->getId()));
    }
}
