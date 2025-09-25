<?php

namespace App\Entity;

use App\Enum\EnvironmentalImpactCategoryEnum;
use App\Repository\EnvironmentalImpactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#mod_locations_environmentalimpact_class.
 */
#[ORM\Entity(repositoryClass: EnvironmentalImpactRepository::class)]
class EnvironmentalImpact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: EnvironmentalImpactCategoryEnum::class, options: ['comment' => 'The environmental impact category of this value.'])]
    private EnvironmentalImpactCategoryEnum $category;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, options: ['comment' => 'Amount of this portion in g/kWh.'])]
    private string $amount;

    #[ORM\ManyToOne(inversedBy: 'environImpact')]
    #[ORM\JoinColumn(nullable: false)]
    private EnergyMix $energyMix;

    public function __construct(
        EnvironmentalImpactCategoryEnum $category,
        string $amount,
        EnergyMix $energyMix,
    ) {
        $this->category = $category;
        $this->amount = $amount;
        $this->energyMix = $energyMix;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): EnvironmentalImpactCategoryEnum
    {
        return $this->category;
    }

    public function setCategory(EnvironmentalImpactCategoryEnum $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getEnergyMix(): EnergyMix
    {
        return $this->energyMix;
    }

    public function setEnergyMix(EnergyMix $energyMix): static
    {
        $this->energyMix = $energyMix;

        return $this;
    }
}
