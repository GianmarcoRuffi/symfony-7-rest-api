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


    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Brand name cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Brand name length must be at least {{ limit }} characters long', maxMessage: 'Brand name length must not exceed {{ limit }} characters.')]
    private ?string $Brand = null;


    #[ORM\Column(name: "engine_serial",length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Engine Serial cannot be empty.')]
    #[Assert\Length(min: 5, max: 50, minMessage: 'Engine Serial length must be at least {{ limit }} characters long', maxMessage: 'Engine Serial length must not exceed {{ limit }} characters.')]
    private ?string $EngineSerial = null;


    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Color cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Color text length must be at least {{ limit }} characters long', maxMessage: 'Color text length must not exceed {{ limit }} characters.')]
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

    public function getEngineSerial(): ?string
    {
        return $this->EngineSerial;
    }

    public function setEngineSerial(string $EngineSerial): static
    {
        $this->EngineSerial = $EngineSerial;

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
