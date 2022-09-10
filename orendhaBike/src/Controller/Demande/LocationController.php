<?php

namespace App\Controller\Demande;

use App\Entity\Clients;
use App\Form\LocationType;
use App\Repository\ProduitRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/demande/location', name: 'app_demande_location')]
    public function index(Request $request,EntityManagerInterface $em,Slugify $slugger, ProduitRepository $produitRepository): Response
    {
        $clients = new Clients();
        $form = $this->createForm(LocationType::class,$clients);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($clients);
            $em->flush();
        }



        return $this->render('demande/location/index.html.twig', [
            'form' => $form->createView(),


        ]);
    }

}
