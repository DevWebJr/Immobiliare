<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @param PropertyRepository $propertyRepository
     * @Route("/", name="home")
     * @return Response
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        $properties = $propertyRepository->findLatest();
        return $this->render('page/index.html.twig',[
            'properties' => $properties
        ]);
    }
}
