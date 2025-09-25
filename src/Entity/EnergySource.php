<?php

namespace App\Entity;

use App\Enum\EnergySourceCategoryEnum;
use App\Repository\EnergySourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#mod_locations_energysource_class.
 */
#[ORM\Entity(repositoryClass: EnergySourceRepository::class)]
class EnergySource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: EnergySourceCategoryEnum::class, options: ['comment' => 'The type of energy source.'])]
    private EnergySourceCategoryEnum $source;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, options: ['comment' => 'Percentage of this source (0-100) in the mix.'])]
    private string $percentage;

    #[ORM\ManyToOne(inversedBy: 'energySources')]
    #[ORM\JoinColumn(nullable: false)]
    private EnergyMix $energyMix;

    public function __construct(
        EnergySourceCategoryEnum $source,
        string $percentage,
        EnergyMix $energyMix,
    ) {
        $this->source = $source;
        $this->percentage = $percentage;
        $this->energyMix = $energyMix;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): EnergySourceCategoryEnum
    {
        return $this->source;
    }

    public function setSource(EnergySourceCategoryEnum $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getPercentage(): string
    {
        return $this->percentage;
    }

    public function setPercentage(string $percentage): static
    {
        $this->percentage = $percentage;

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
