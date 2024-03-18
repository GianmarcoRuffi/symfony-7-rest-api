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
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 20)]
    private ?string $Brand = null;

    
     #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'Must be an integer.')]
    #[Assert\Positive]
      private ?int $EngineSize = null;
    
    
    #[ORM\Column(length: 50, nullable: true)]
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

