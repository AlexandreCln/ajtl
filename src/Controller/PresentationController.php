<?php

namespace App\Controller;

use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PresentationController extends AbstractController
{
    /**
     * @Route("/presentation", name="presentation")
     */
    public function index(PresentationRepository $presentationnRepo)
    {
        return $this->render('presentation/index.html.twig', [
            'presentation' => $presentationnRepo->findUniqueRow(),
        ]);
    }

    /**
     * @Route("/admin/presentation", name="admin_presentation")
     */
    public function adminIndex(Request $request, PresentationRepository $presentationRepo, EntityManagerInterface $em)
    {
        // Get the unique row of Presentation table
        $presentation = $presentationRepo->findUniqueRow();
        // or create a new
        if (!$presentation instanceof Presentation) {
            $presentation =  new Presentation();
        }

        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($presentation);
            $em->flush();

            $this->addFlash('success', 'Les informations ont bien été mises à jour !');
        }


        return $this->render('admin/presentation/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
