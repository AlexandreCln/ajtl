<?php

namespace App\Controller;

use App\Entity\EmailNewsletter;
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
     * @Route("/newsletter/render", name="newsletter_render")
     */
    public function renderNewsletter(): Response
    {
        $newsletterForm = $this
            ->createForm(NewsletterType::class, null, [
                'action' => $this->generateUrl('newsletter_new_email')])
            ->createView();

        return $this->render('home/_newsletter.html.twig', [
            'newsletterForm' => $newsletterForm
        ]);
    }

    /**
     * @Route("/newsletter/new-email", name="newsletter_new_email")
     */
    public function newEmailNewsletter(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(NewsletterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailNewsletter = new EmailNewsletter();
            $emailNewsletter->setEmail($form->getData()['email']);
            // Todo: gérer les checkboxes (relation Newsletter::news['roleplay'],/ciné... ?) puis update message flash

            $em->persist($emailNewsletter);
            //Todo: uncomment when database will be created
//            $em->flush();

//            if ( > 1) {
//                $this->addFlash('success', 'Vous êtes inscrit aux la newsletters '  );
//            } else {
//                $this->addFlash('success', 'Vous êtes inscrit à la newsletter ' . );
//            }
//        } else {
//            $this->addFlash('danger', 'Un problème est survenu lors de l\'enregistrement de votre email);
        }

        return $this->redirectToRoute('home');
    }
}
