<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VendeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VendeurRepository::class)
 */
class Vendeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseChamps;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $superficieChamps;

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
}
