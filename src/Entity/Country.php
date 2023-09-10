<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 200)]
    private ?string $regex_tax_number = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $tax_percentage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRegexTaxNumber(): ?string
    {
        return $this->regex_tax_number;
    }

    public function setRegexTaxNumber(string $regex_tax_number): static
    {
        $this->regex_tax_number = $regex_tax_number;

        return $this;
    }

    public function getTaxPercentage(): ?string
    {
        return $this->tax_percentage;
    }

    public function setTaxPercentage(string $tax_percentage): static
    {
        $this->tax_percentage = $tax_percentage;

        return $this;
    }
}
