<?php

namespace App\Controller;

use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/subscribe-newsletter", name="subscribe_newsletter")
     */
    public function subscribeNewsletter(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(NewsletterType::class, null,[
            'action' => $this->generateUrl('subscribe_newsletter')
        ]);
        $form->handleRequest($request);

        //todo:
        // Gérer si email deja enregistrée, enregistrer seulement les news chéckés ?
        // + le cas ou rien n'est sélectionné, ne rien faire (retour home + flash danger)
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());

            $this->addFlash('success', 'Votre inscription à bien été prise en compte.');
//
//
//        } else {
//            $this->addFlash('danger', 'Une erreur est survenu lors de l\'inscription à la newsletter);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/_newsletter.html.twig', [
            'newsletterForm' => $form->createView()
        ]);
    }
}
