<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Clients;
use App\Entity\Location\Velo;
use App\Entity\Produit;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use http\Client;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new PicsumPhotosProvider($faker));

        for ($i = 0; $i < 10; $i++) {
            $velo = new  Velo();
            $velo->setNom('velo eletrique')
                ->setDescription($faker->text());
            $manager->persist($velo);
        }
        for ($i = 0; $i < 10; $i++) {
            $clients = new  Clients();
            $clients->setNom($faker->firstName())
                ->setPrenom($faker->lastName())
                ->setEmail($faker->email())
                ->setAdresse($faker->address())
                ->setCodePostal('34000')
                ->setMessage($faker->text());
            $manager->persist($clients);
        }

        for ($i = 0; $i < 3; $i++) {
            $categorie = new Categorie();
            $categorie->setName($faker->department)
                ->setSlug(strtolower($this->slugger->slug($categorie->getName())));

            $manager->persist($categorie);


            for ($i = 0; $i < mt_rand(15, 20); $i++) {
                $produit = new Produit();

                $produit->setName($faker->productName)
                    ->setPrice($faker->price(1000, 40000))
                    ->setSlug(strtolower($this->slugger->slug($produit->getName())))
                    ->setCategorie($categorie)
                ->setDescriptionCourte($faker->text())
                ->setMainpicture($faker->imageUrl(400,400,true));

                $manager->persist($produit);

            }

        }


        $manager->flush();
    }
}
