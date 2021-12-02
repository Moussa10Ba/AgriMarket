<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext = {"groups"={"categorieRead"}},
 * denormalizationContext = {"groups"={"categorieWrite"}},
 *          itemOperations = {
 *              "getCategorie" = {
 *                     "method" = "get",
 *                     "path" = "categories/{id}",
 *                     "security"="is_granted('ROLE_Admin')",
 *                     "security_message" = "Contacter L'administrateur du site ",
 *                  },
 *                    
 *                  "getProduitsByCategorie" = {
 *                          "method" = "get",
 *                          "path"="categorie/{id}/produits",
 *                          "controller"="App\Controller\CategorieController::getProduitsByCategorie",      
 *                      },
 *                      "put" = {
 *                          "security"="is_granted('ROLE_Admin')",
 *                           "security_message" = "Contacter L'administrateur du site ",
 *                              },
 *                  },
 *           collectionOperations = {
 *                      "post" = {
 *                          "security"="is_granted('ROLE_Admin')",
 *                           "security_message" = "Contacter L'administrateur du site ",
 *                      },
 *                       "getœ" = {
 *                          "security"="is_granted('ROLE_Admin')",
 *                          "security_message" = "Contacter L'administrateur du site ",
 *                      },
 *                     
 * 
 *                      }
 *  
 * )
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categorieRead"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categorieRead","categorieWrite"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="categorie")
     * @ApiSubresource()
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }

        return $this;
    }
}
