<?php

namespace App\Entity;

use App\Repository\EngineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EngineRepository::class)]
#[ORM\Index(columns: ['serial_code'], name: 'engine_serial_code_idx')]

class Engine
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $SerialCode = null;

    #[ORM\Column]
    private ?int $Horsepower = null;

    #[ORM\Column(length: 50)]
    private ?string $Manufacturer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSerialCode(): ?string
    {
        return $this->SerialCode;
    }

    public function setSerialCode(string $SerialCode): static
    {
        $this->SerialCode = $SerialCode;

        return $this;
    }

    public function getHorsepower(): ?int
    {
        return $this->Horsepower;
    }

    public function setHorsepower(int $Horsepower): static
    {
        $this->Horsepower = $Horsepower;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->Manufacturer;
    }

    public function setManufacturer(string $Manufacturer): static
    {
        $this->Manufacturer = $Manufacturer;

        return $this;
    }
}
