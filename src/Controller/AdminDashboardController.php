<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function index()
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
