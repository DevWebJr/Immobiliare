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
     * @Route("/admin/property/edit/{id}", name="admin_property_edit")
     * @return Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Le bien a été modifié.');
            return $this->redirectToRoute('show_all_properties'); 
        }
        
        return $this->render('property/property_edit.html.twig', [ 
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    
    
    /**
     * @Route("/admin/property/create", name="admin_property_create")
     * @return Response
     */
    public function new(Request $request)
    {
        $property = new Property();
        
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->entityManager->persist($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'Le bien a été ajouté.');
            return $this->redirectToRoute('show_all_properties'); 
        }
        
        return $this->render('property/property_create.html.twig', [ 
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/admin/property/delete/{id}", name="admin_property_delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request)
    {   
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($property);
            $this->entityManager->flush();
            $this->addFlash('danger', 'Le bien a été supprimé.');
        }       
        return $this->redirectToRoute('show_all_properties');
    }
}