<?php

namespace App\Entity;

use App\Repository\EngineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EngineRepository::class)]
#[ORM\Index(columns: ['serial_code'], name: 'engine_serial_code_idx')]

class Engine
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Name cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Name length must be at least {{ limit }} characters long', maxMessage: 'Name length must not exceed {{ limit }} characters.')]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Serial Code is mandatory.')]
    #[Assert\Length(min: 5, max: 255, minMessage: 'Serial Code length must be at least {{ limit }} characters long', maxMessage: 'Serial Code length must not exceed {{ limit }} characters.')]
    private ?string $SerialCode = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Horsepower cannot be empty.')]
    #[Assert\Type(type: 'integer', message: 'Horsepower must be a number.')]
    #[Assert\Positive(message: 'Horsepower cannot be negative.')]
    private ?int $Horsepower = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Manufacturer cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Manufacturer name length must be at least {{ limit }} characters long', maxMessage: 'Manufacturer name length must not exceed {{ limit }} characters.')]
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
