<?php

namespace App\Entity\Location;

use App\Repository\Location\TypeMoteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeMoteurRepository::class)]
class TypeMoteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $electrique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElectrique(): ?string
    {
        return $this->electrique;
    }

    public function setElectrique(string $electrique): self
    {
        $this->electrique = $electrique;

        return $this;
    }
}
