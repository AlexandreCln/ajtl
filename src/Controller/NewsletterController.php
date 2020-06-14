<?php

namespace App\Controller;

use App\Entity\NewsletterTheme;
use App\Form\ContactFormType;
use App\Form\NewsletterThemeType;
use App\Repository\NewsletterThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/theme", name="newsletter_theme_index")
     */
    public function indexTheme(NewsletterThemeRepository $newsletterThemeRepository)
    {
        return $this->render('admin/newsletter_theme/index.html.twig', [
            'newsletter_themes' => $newsletterThemeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newsletter/theme/nouveau", name="newsletter_theme_new", methods={"GET","POST"})
     */
    public function newTheme(Request $request)
    {
        $newsletterTheme = new NewsletterTheme();
        $form = $this->createForm(NewsletterThemeType::class, $newsletterTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletterTheme);
            $entityManager->flush();

            return $this->redirectToRoute('newsletter_theme_index');
        }

        return $this->render('admin/newsletter_theme/new.html.twig', [
            'newsletter_theme' => $newsletterTheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newsletter_theme_edit", methods={"GET","POST"})
     */
    public function editTheme(Request $request, NewsletterTheme $newsletterTheme): Response
    {
        $form = $this->createForm(NewsletterThemeType::class, $newsletterTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletter_theme_index');
        }

        return $this->render('admin/newsletter_theme/edit.html.twig', [
            'newsletter_theme' => $newsletterTheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newsletter_theme_delete", methods={"DELETE"})
     */
    public function deleteTheme(Request $request, NewsletterTheme $newsletterTheme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsletterTheme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newsletterTheme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newsletter_theme_index');
    }

    /**
     * @Route("/email", name="email")
     * @throws TransportExceptionInterface
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('alex97.coul@gmail.com')
            //->addTo('toto@example.com')
            //->addTo('titi@example.com')
            // or
            //->cc('toto@example.com', 'titi@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }
}
