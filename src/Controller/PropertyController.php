<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PropertyRepository $propertyRepository, EntityManagerInterface $entityManager)
    {
        $this->propertyRepository = $propertyRepository;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/biens", name="show_all_properties")
     */
    public function index(): Response
    {
        
        $properties = $this->propertyRepository->findLatest();
        return $this->render('property/index.html.twig', [
            'current_main' => 'show_all_properties',
            'properties' => $properties
        ]);
    }
}
