<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\PresentationType;
use App\Repository\InformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PresentationController extends AbstractController
{
    /**
     * @Route("/presentation", name="presentation")
     */
    public function index(InformationRepository $informationRepo)
    {
        return $this->render('presentation/index.html.twig', [
            'information' => $informationRepo->findOneBy([]),
        ]);
    }

    /**
     * @Route("/admin/presentation", name="admin_presentation")
     */
    public function adminIndex(Request $request, InformationRepository $informationRepo, EntityManagerInterface $em)
    {
        // Get the unique row of Information table
        $information = $informationRepo->findOneBy([]);
        // or create a new
        if (! $information instanceof Information) {
            $information =  new Information();
        }

        $form = $this->createForm(PresentationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($information);
            $em->flush();

            $this->addFlash('success', 'Les informations ont bien été mises à jour !');
        }


        return $this->render('admin/presentation/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
