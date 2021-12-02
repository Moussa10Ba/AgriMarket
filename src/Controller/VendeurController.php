<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class VendeurController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    /**
     * @Route("/api/vendeurs/{id}/produits", name="get_users_products", methods={"GET"})
     */
    public function get_users_products($id, VendeurRepository $vendeurRepo): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
       $vendeur = $vendeurRepo->findOneBy(["id"=>$id]);
       if($vendeur && $user===$vendeur || $user instanceof Admin){
           return $this->json($vendeur->getProduits(),200,[]);
       }elseif($vendeur && $user!=$vendeur){
        return $this->json(["message"=>"Vous ne pouvez afficher que vos produits"],Response::HTTP_NOT_FOUND);
       }
       return $this->json(["message"=>"Ce Vendeur n'existe Pas"],Response::HTTP_NOT_FOUND);
    }
}
