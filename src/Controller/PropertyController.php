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
     * @return Response
     */
    public function index(): Response
    {
        
        $properties = $this->propertyRepository->findLatest();
        return $this->render('property/index.html.twig', [
            'current_main' => 'show_all_properties',
            'properties' => $properties
        ]);
    }
    
    /**
     * @Route("/biens/{slug}-{id}", name="show_one_property", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('show_one_property', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show_one_property.html.twig', [
            'property' => $property,
            'current_main' => 'show_all_properties'
            ]);
    }
}
