<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [

        ]);
    }

    #[Route('/admin/categorie/create', name: 'categorie_create')]
    public function create(): Response
    {
        return $this->render('categorie/create.html.twig', [

        ]);
    }

    #[Route('/admin/categorie/{id}/edit', name: 'categorie_edit')]
    public function edition($id, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->find($id);
        return $this->render('categorie/edition.html.twig', [
            'categorie' => $categorie
        ]);
    }

}
