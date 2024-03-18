<?php

namespace App\Entity;

use App\Repository\BikeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Brand cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage:'Brand length must be at least {{ limit }} characters long', maxMessage:'Brand length must not exceed {{ limit }} characters.')]
    private ?string $Brand = null;


    #[ORM\Column]
    #[Assert\NotBlank(message: 'Engine Size cannot be empty.')]
    #[Assert\Type(type: 'integer', message: 'Engine size must be a number.')]
    #[Assert\Positive(message: 'Engine Size cannot be negative.')]
    private ?int $EngineSize = null;


    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $Color = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): static
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getEngineSize(): ?int
    {
        return $this->EngineSize;
    }

    public function setEngineSize(int $EngineSize): static
    {
        $this->EngineSize = $EngineSize;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(?string $Color): static
    {
        $this->Color = $Color;

        return $this;
    }
}
