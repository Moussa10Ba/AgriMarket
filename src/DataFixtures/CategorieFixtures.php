<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $tabCat = ["Cereales","Noisettes","Melons"];
        

       for($i=0;$i<3;$i++){
        $cat = new Categorie();
        $cat->setLibelle($tabCat[$i]);
        $manager->persist($cat);
       }

        $manager->flush();
    }
}
