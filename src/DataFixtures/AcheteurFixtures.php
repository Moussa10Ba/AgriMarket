<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Profil;
use App\Entity\Acheteur;
use App\DataFixtures\ProfileFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AcheteurFixtures extends Fixture implements DependentFixtureInterface
{
    private $encode;
    private $faker;
    public function __construct(UserPasswordHasherInterface $encode){
        $this->encode = $encode;
        
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $tabTel = ["774171750","777030134","781798136","772676893","773601776","775386851","776459179","777677045","775171063","775945425"];
        $ville = ["Dakar", "Thies", "Guediawaye", "Pikine", "Parcelle", "Malika", "Ourossogui", "Louga", "SaintLouis", "Matam"];
        $tabphoto=[
            "image1.jpg",
            "image3.jpg",
            "image4.jpg"
        ];

        for($i=0; $i<10; $i++){
            $acheteur = new Acheteur();
            $password =$this->encode->hashPassword($acheteur,"passer");
            $acheteur->setPassword($password);
            $acheteur->setNom($faker->lastName);
            $acheteur->setPrenom($faker->firstNameMale);
            $acheteur->setEmail($faker->email);
            $acheteur->setProfil($this->getReference(ProfileFixtures::PROFIL_ACHETEUR_REFERENCE));
            $acheteur->setTelephone($tabTel[$i]);
            $acheteur->setProfession("Entrepreneur");
            $acheteur->setAdresse($ville[$i]);
            $acheteur->setVille($ville[$i]);
            $acheteur->setStatut(true);
            $acheteur->setPhoto($faker->randomElement($tabphoto));
            $manager->persist($acheteur);
            
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
