<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/api/categorie/{id}/produits", name="getProduitsByCategorie", methods="GET")
     */
    public function getProduitsByCategorie($id, CategorieRepository $catrepo): Response
    {
        $categorie = $catrepo->findOneBy(["id"=>$id]);
        if($categorie){
            return $this->json($categorie->getProduits(),200,[]);
        }
        return $this->json(["message"=>"Cette Categorie n'existe pas",Response::HTTP_NOT_FOUND]);
    }
}
