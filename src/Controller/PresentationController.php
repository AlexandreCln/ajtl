<?php

namespace App\Controller;

use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Entity\PresentationPerson;
use App\Form\PresentationPersonType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresentationRepository;
use App\Service\UploaderHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            $em->persist($presentation);
            $em->flush();
        }

        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($presentation);
            $em->flush();

            $this->addFlash('success', 'Les informations ont bien été mises à jour !');
        }

        return $this->render('admin/presentation/index.html.twig', [
            'form' => $form->createView(),
            'presentationPersons' => $presentation->getPresentationPersons()
        ]);
    }

    /**
     * @Route("/admin/presentation/ajout-membre-presentation", name="admin_new_presentation_person", methods={"GET","POST"})
     */
    public function newPresentationPerson(Request $request, PresentationRepository $presentationRepo, UploaderHelper $uploaderHelper): Response
    {
        $presentationPerson = new PresentationPerson();
        $form = $this->createForm(PresentationPersonType::class, $presentationPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['pictureFile']->getData();

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadPresentationPersonPicture($uploadedFile);
                $presentationPerson->setPictureFilename($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presentationPerson);
            $presentationRepo->findUniqueRow()->addPresentationPerson($presentationPerson);
            $entityManager->flush();

            return $this->redirectToRoute('admin_presentation');
        }

        return $this->render('admin/presentation/new_person.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/presentation/editer-membre-presentation/{id}", name="admin_edit_presentation_person", methods={"GET","POST"})
     */
    public function editPresentationPerson(Request $request, PresentationPerson $presentationPerson, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(PresentationPersonType::class, $presentationPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['pictureFile']->getData();

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadPresentationPersonPicture($uploadedFile);
                $presentationPerson->setPictureFilename($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_presentation');
        }

        return $this->render('admin/presentation/edit_person.html.twig', [
            'presentationPerson' => $presentationPerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/presentation/delete-person/{id}", name="admin_delete_presentation_person", methods={"DELETE"})
     */
    public function deletePresentationPerson(Request $request, PresentationPerson $presentationPerson, PresentationRepository $presentationRepo): Response
    {
        if ($this->isCsrfTokenValid('delete' . $presentationPerson->getId(), $request->request->get('_token'))) {
            $presentationRepo->findUniqueRow()->removePresentationPerson($presentationPerson);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presentationPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_presentation');
    }
}
