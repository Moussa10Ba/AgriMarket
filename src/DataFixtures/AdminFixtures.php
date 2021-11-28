<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Admin;
use App\DataFixtures\ProfileFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder=$encoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $tabTel = ["777788888","777788888","777788888","777788888","777788888"];
        $ville = ["Hiraye","Thilogne", "Guediawaye", "Ourossogui", "Matam"];

        $faker = Factory::create();

        for ($i=0 ;$i<5; $i++){
            $admin = new Admin();
            $password =$this->encoder->hashPassword($admin,"passer");
           // $admin->setMatricule("mat".$i);
            $admin->setPassword($password);
            $admin->setStatut(true);
            $admin->setPrenom($faker->firstNameMale);
            $admin->setNom($faker->lastName);
            $admin->setEmail($faker->email);
           // $admin->setLogin($faker->username);
            $admin->setProfil($this->getReference(ProfileFixtures::PROFIL_ADMIN_REFERENCE));
            $admin->setTelephone($tabTel[$i]);
            $admin->setAdresse($ville[$i]);
            $admin->setVille($ville[$i]);
            $tabphoto=[
                "image1.jpg",
                "image3.jpg",
                "image4.jpg"
            ];

            $admin->setPhoto($faker->randomElement($tabphoto));
            $manager->persist($admin);
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return array(
            ProfileFixtures::class,
        );
    }
}
