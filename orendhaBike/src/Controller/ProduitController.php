<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProduitController extends AbstractController
{
    #[Route('/{slug}', name: 'app_produit_categorie')]
    public function categorie($slug, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findOneBy(['slug' => $slug]);

        if (!$categorie) {
            throw new NotFoundHttpException("la categorie n'existe pas ");
        }
        return $this->render('produit/categorie.html.twig', [
            'slug' => $slug,
            'categorie' => $categorie
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}",name="product_show")
     */
    public function show($slug, ProduitRepository $produitRepository, UrlGeneratorInterface $generator)
    {


        $produit = $produitRepository->findOneBy(['slug' => $slug]);
        if (!$produit) {
            // Ici avec le createNotFound me permet de lancer une excpetion indant que produit n'exsite pas
            throw $this->createNotFoundException("le produit demandé n'existe pas ");
        }
        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }

    /**
     * @Route("/admin/produit/creation",name="creation_produit")
     */
    public function creation ()
    {



        return $this->render('produit/creation.html.twig', [

        ]);
    }


}
