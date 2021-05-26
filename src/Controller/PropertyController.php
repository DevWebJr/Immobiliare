<?php

namespace App\Controller;

use App\Entity\Property;
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
        $property  = new Property();
        $property->setTitle('Mon premier bien');
        $property->setPrice(200000);
        $property->setRooms(4);
        $property->setBedrooms(3);
        $property->setDescription('Voici la description de mon premier bien');
        $property->setSurface(60);
        $property->setFloor(4);
        $property->setHeat(0);
        $property->setCity('Strasbourg');
        $property->setAddress('9 boulevard Wilson');
        $property->setPostalCode(67000);        
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($property);
        $entityManager->flush();

        return $this->render('property/index.html.twig', [
            'current_main' => 'show_all_properties'
        ]);
    }
}
