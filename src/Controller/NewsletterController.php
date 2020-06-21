<?php

namespace App\Controller;

use App\Entity\NewsletterSubscriber;
use App\Entity\NewsletterTheme;
use App\Form\NewsletterThemeType;
use App\Form\NewsletterSubscriberType;
use App\Repository\NewsletterSubscriberRepository;
use App\Repository\NewsletterThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/subscribe-newsletter", name="subscribe_newsletter")
     */
    public function subscribeNewsletter(Request $request, EntityManagerInterface $em, NewsletterSubscriberRepository $subscriberRepo): Response
    {
        $subscriber = new NewsletterSubscriber();
        $form = $this->createForm(NewsletterSubscriberType::class, $subscriber,
            ['action' => $this->generateUrl('subscribe_newsletter')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data->getNewsletterThemes()->isEmpty()) {
                $this->addFlash('danger', 'Vous devez sélectionner au moins une newsletter.');
            } else {
                $existingSubscriber = $subscriberRepo->findOneBy(['email' => $data->getEmail()]);

                if ($existingSubscriber instanceof NewsletterSubscriber) {
                    $subscriber = $existingSubscriber;
                    foreach ($data->getNewsletterThemes() as $theme) {
                        $subscriber->addNewsletterTheme($theme);
                    }
                }

                $em->persist($subscriber);
                $em->flush();
                $this->addFlash('success', 'Votre abonnement aux newsletters à bien été mis à jour.');
            }

            return $this->redirectToRoute('home');
        }

        return $this->render('home/_newsletter.html.twig', [
            'newsletterForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/envoyer-newsletter", name="newsletter_send")
     * @throws TransportExceptionInterface
     */
    public function sendNewsletter(MailerInterface $mailer, Request $request)
    {
//        $form = $this->createForm(NewsletterSubscriberType::class);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {

        $newsletter = (new Email())
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

        $mailer->send($newsletter);

        $this->addFlash('success', 'La newsletter à bien été envoyée !');

        return $this->redirectToRoute('newsletter_send');
//        }

//        return $this->render('');
    }

    /**
     * @Route("/admin/newsletter/theme", name="newsletter_theme_index")
     */
    public function indexTheme(NewsletterThemeRepository $newsletterThemeRepository)
    {
        return $this->render('admin/newsletter_theme/index.html.twig', [
            'newsletter_themes' => $newsletterThemeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/theme-newsletter/nouveau", name="newsletter_theme_new", methods={"GET", "POST"})
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
     * @Route("/admin/theme-newsletter/{id}/edit", name="newsletter_theme_edit", methods={"GET","POST"})
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
     * @Route("/admin/theme-newsletter/delete/{id}", name="newsletter_theme_delete", methods={"DELETE"})
     */
    public function deleteTheme(Request $request, NewsletterTheme $newsletterTheme): Response
    {
        if ($this->isCsrfTokenValid('delete' . $newsletterTheme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newsletterTheme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newsletter_theme_index');
    }
}
