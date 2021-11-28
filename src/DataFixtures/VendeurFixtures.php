<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Profil;
use App\Entity\Vendeur;
use App\DataFixtures\ProfileFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class VendeurFixtures extends Fixture
{

    private $encode;
    private $faker;
    public function __construct(UserPasswordHasherInterface $encode){
        $this->encode = $encode;
        
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();
        $tabTel = ["774171750","777030134","781798136","772676893","773601776","775386851","776459179","777677045","775171063","775945425"];
        $ville = ["Kolda", "Dahra Jolof", "Patouku", "Thilogne", "Parcelle", "Malika", "Ourossogui", "Louga", "SaintLouis", "Matam"];
        $adrChamps = ["Kolda", "Dahra Jolof", "Patouku", "Thilogne", "Parcelle", "Malika", "Ourossogui", "Louga", "SaintLouis", "Matam"];
        $tabphoto=[
            "image1.jpg",
            "image3.jpg",
            "image4.jpg"
        ];

        for($i=0; $i<10; $i++){
            $vendeur = new Vendeur();
            $password =$this->encode->hashPassword($vendeur,"passer");
            $vendeur->setPassword($password);
            $vendeur->setNom($faker->lastName);
            $vendeur->setPrenom($faker->firstNameMale);
            $vendeur->setEmail($faker->email);
            $vendeur->setProfil($this->getReference(ProfileFixtures::PROFIL_VENDEUR_REFERENCE));
            $vendeur->setTelephone($tabTel[$i]);
            $vendeur->setAdresse($ville[$i]."adresse");
            $vendeur->setVille($ville[$i]);
            $vendeur->setStatut(true);
            $vendeur->setPhoto($faker->randomElement($tabphoto));
            $vendeur->setAdresseChamps($adrChamps[$i]);
            $manager->persist($vendeur);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            ProfileFixtures::class,
        );
    }
}
