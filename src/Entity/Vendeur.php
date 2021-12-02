<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VendeurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"vendeurRead"}},
 *  denormalizationContext={"groups"={"vendeurWrite"}},
 *  itemOperations = {
 * "get"= {
 *  "security"="is_granted('VIEW',object)",
 *     "security_message"="Acces Denied",
 * },
 * "put" = {
 * "security"="is_granted('VIEW',object)",
 *     "security_message"="Acces Denied",
 * },
 * "delete" = {
 * "security"="is_granted('DELETE_',object)",
 *     "security_message"="Acces Denied",
 * },
 * },
 * collectionOperations = {
 *     "get"={
 *      "security"="is_granted('VIEW',object)",
 *      "security_message"="Acces Denied",
 * }
 * ,"post"
 *  },
 * )
 * @ORM\Entity(repositoryClass=VendeurRepository::class)

 */
class Vendeur extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"vendeurWrite","vendeurRead"})
     * @Groups({"produitRead"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $adresseChamps;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $superficieChamps;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="vendeur")
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

    public function getAdresseChamps(): ?string
    {
        return $this->adresseChamps;
    }

    public function setAdresseChamps(?string $adresseChamps): self
    {
        $this->adresseChamps = $adresseChamps;

        return $this;
    }

    public function getSuperficieChamps(): ?string
    {
        return $this->superficieChamps;
    }

    public function setSuperficieChamps(?string $superficieChamps): self
    {
        $this->superficieChamps = $superficieChamps;

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
            $produit->setVendeur($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getVendeur() === $this) {
                $produit->setVendeur(null);
            }
        }

        return $this;
    }
}
