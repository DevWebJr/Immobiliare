<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController  {
    
    public function __construct(PropertyRepository $propertyRepository, EntityManagerInterface $entityManager)
    {
        $this->propertyRepository = $propertyRepository;
        $this->entityManager = $entityManager;
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
     * @Route("/admin/edit/{id}", name="admin_property_edit")
     * @return Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->entityManager->flush();
            return $this->redirectToRoute('show_all_properties'); 
        }
        
        return $this->render('property/property_edit.html.twig', [ 
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}