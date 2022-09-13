<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function creation(FormFactoryInterface $factory, SluggerInterface $slugger, Request $request, EntityManagerInterface $manager)
    {
        $builder = $factory->createBuilder(ProduitType::class);
        $form = $builder->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $produit->setSlug(strtolower($slugger->slug($produit->getName())));
            $manager->persist($produit);
            $manager->flush();
        }
        $formView = $form->createView();
        return $this->render('produit/creation.html.twig', [
            'formView' => $formView

        ]);
    }

    /**
     * @Route("/admin/produit/{id}/edit",name="produit_edit")
     */
    public function edit($id, ProduitRepository $produitRepository, Request $request, EntityManagerInterface $manager)
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            return $this->redirectToRoute('product_show',[
                'category_slug'=>$produit->getCategorie()->getSlug(),
                'slug'=>$produit->getSlug()
            ]);
        }
        // $form->setData($produit);

        $formView = $form->createView();

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'formView' => $formView

        ]);

    }
}
