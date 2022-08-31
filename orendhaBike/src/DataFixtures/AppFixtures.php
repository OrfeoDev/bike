<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use App\Entity\Location\Velo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use http\Client;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++)
        {
         $velo = new  Velo();
         $velo->setNom('Vtc'.$i)
             ->setDescription('description du velo');
             $manager->persist($velo);
        }

        $manager->flush();
    }
}
