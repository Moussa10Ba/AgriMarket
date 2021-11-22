<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AcheteurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"acheteurRead"}},
 *  denormalizationContext={"groups"={"acheteurWrite", "userWrite"}},
 * itemOperations = {
 * "get","put","delete",
 * },
 * collectionOperations = {
 * "get","post",
 * },
 * )
 * @ORM\Entity(repositoryClass=AcheteurRepository::class)
 */
class Acheteur extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userRead"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userRead"})
     */
    private $profession;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="acheteur")
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

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

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
            $commande->setAcheteur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getAcheteur() === $this) {
                $commande->setAcheteur(null);
            }
        }

        return $this;
    }
}
