<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController  {
    
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }
    
    /**
     * @Route("/admin", name="admin_property")
     * @return Response
     */
    public function index()
    {
        $properties = $this->propertyRepository->findAll();
        
        return $this->render('property/property_manage.html.twig', compact('properties'));
    }
    
    /**
     * @Route("/admin/{id}/edit", name="admin_property_edit")
     * @return Response
     */
    public function edit(Property $property)
    {
        return $this->render('property/property_edit.html.twig', compact('property'));
    }
}