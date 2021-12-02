<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext = {"groups"={"produitRead"}},
 * denormalizationContext = {"groups"={"produitWrite"}},
 *              collectionOperations = {
 *                  "get" = {
 *                      "path"="produits",
 *                      },
 *                   "post"={
 *                          "security"="is_granted('POST',object)",
 *                          "security_message"="Vous n'avez pas acces a cette ressource",
 *                          "path" = "vendeurs/produits",
 *                    },
 *                  
 *               },
 *               itemOperations = {
 *                    "get" = {
 *                          "path"="produits/{id}",
 *                         },
 *                     "delete" = {
 *                          "security"="is_granted('DELETE_P',object)",
 *                          "security_message"="Vous ve pouvez pas supprimer cette ressource",
 *                          "path" = "vendeurs/produits/{id}",
 *                      }, 
 *                      "put" = {
 *                          "security"="is_granted('EDIT',object)",
 *                          "security_message"="Vous ve pouvez pas modifier cette ressource",
 *                          "path" = "vendeurs/produits/{id}",
 *                      }, 
 *               },
 * 
 * )
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"produitRead"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"produitRead","produitWrite"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"produitRead","produitWrite"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"produitRead","produitWrite"})
     */
    private $paysDorigine;

    /**
     * @ORM\Column(type="float")
     * @Groups({"produitRead","produitWrite"})
     */
    private $prixKg;

    /**
     * @ORM\Column(type="float")
     * @Groups({"produitRead","produitWrite"})
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"produitWrite"})
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Vendeur::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"produitRead","produitWrite"})
     */
    private $vendeur;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="produit")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPaysDorigine(): ?string
    {
        return $this->paysDorigine;
    }

    public function setPaysDorigine(string $paysDorigine): self
    {
        $this->paysDorigine = $paysDorigine;

        return $this;
    }

    public function getPrixKg(): ?float
    {
        return $this->prixKg;
    }

    public function setPrixKg(float $prixKg): self
    {
        $this->prixKg = $prixKg;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeur $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }
}
