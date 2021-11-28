<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProduitFixtures extends Fixture
{
        

    public function load(ObjectManager $manager): void
    {
    
        $produit =  new Produit();

        
        

        $manager->flush();
    }
}
