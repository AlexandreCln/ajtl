<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActivitiesController extends AbstractController
{
    /**
     * @Route("/activites", name="activities")
     */
    public function show()
    {
        return $this->render('activities/show.html.twig', [
            'controller_name' => 'ActivitiesController',
        ]);
    }
}
