<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="show_all_properties")
     */
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'current_main' => 'show_all_properties'
        ]);
    }
}
