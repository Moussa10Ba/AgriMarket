<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture
{
    public const PROFIL_ADMIN_REFERENCE = 'profil_admin';
    public const PROFIL_ACHETEUR_REFERENCE = 'profil_acheteur';
    public const PROFIL_VENDEUR_REFERENCE = 'profil_vendeur';
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $tab = ["Admin", "Acheteur", "Vendeur"];
        for ($i=1; $i <4 ; $i++) { 
            $profil = new Profil();
            if ($i==1) {
                $profil->setLibelle("Admin");
                $profil->setIsArchived(false);
                $this->addReference(self::PROFIL_ADMIN_REFERENCE, $profil);

            }if ($i==2) {
                $profil->setLibelle("Acheteur");
                $profil->setIsArchived(false);
                $this->addReference(self::PROFIL_ACHETEUR_REFERENCE, $profil);

            }if ($i==3) {
                $profil->setLibelle("Vendeur");
                $profil->setIsArchived(false);
                $this->addReference(self::PROFIL_VENDEUR_REFERENCE, $profil);

            }
            $manager->persist($profil);
        }
        $manager->flush();
    }

}