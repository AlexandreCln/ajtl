<?php

namespace App\Controller;

use App\Entity\NewsletterSubscriber;
use App\Entity\NewsletterTheme;
use App\Form\NewsletterSendType;
use App\Form\NewsletterThemeType;
use App\Form\NewsletterSubscriberType;
use App\Repository\NewsletterSubscriberRepository;
use App\Repository\NewsletterThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
                $this->addFlash('success', 'Votre abonnement aux newsletters a bien été mis à jour.');
            }

            return $this->redirectToRoute('home');
        }

        return $this->render('home/_newsletter.html.twig', [
            'newsletterForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/envoyer-newsletter", name="newsletter_send")
     * @param MailerInterface $mailer
     * @param Request $request
     */
    public function sendNewsletter(MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(NewsletterSendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $subscribers = $data['theme']->getNewsletterSubscribers();
            $file = $form->get('file')->getData();

            $newsletter = (new TemplatedEmail())
                ->from(new Address('ajtl@example.com', 'AJTL'))
                ->subject($data['subject'])
                ->htmlTemplate('admin/newsletter_send/template.html.twig')
                ->context(['message' => $data['message'],])
                ;

            if ($file) {
                $newsletter->embedFromPath($file->getPathname(), 'image');
            }

            foreach ($subscribers as $subscriber) {
                $newsletter->addTo($subscriber->getEmail());
            }

            try {
                $mailer->send($newsletter);
                $this->addFlash('success', 'La newsletter à bien été envoyée aux abonnés !');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('success', 'Une erreur est survenue et la newsletter n\' à pas pu être envoyée.');
            }
        }

        return $this->render('admin/newsletter_send/index.html.twig', [
            'form' => $form->createView()
        ]);
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
