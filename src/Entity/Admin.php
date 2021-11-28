<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"adminRead"}},
 * denormalizationContext={"groups"={"adminWrite"}},
 * )
 */
class Admin extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userRead"})
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
