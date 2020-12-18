<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Magasin;

class MagasinController extends AbstractController
{
    /**
     * @Route("/magasins", name="magasins")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $shops = $entityManager->getRepository(Magasin::class)->findAll();
        return $this->render('magasin/index.html.twig', [
            'controller_name' => 'MagasinController',
            'shops' => $shops
        ]);
    }


    public function createMagasin() {

    }
}
