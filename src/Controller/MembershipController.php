<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MembershipController extends AbstractController
{
    /**
     * @Route("/adhesion", name="membership")
     */
    public function index()
    {
        return $this->render('membership/index.html.twig');
    }
}
