<?php

namespace App\Controller;

use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PartnerRepository $partnerRepository)
    {
        $partners = $partnerRepository->findBy([], ['updatedAt' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'partners' => $partners
        ]);
    }
}
