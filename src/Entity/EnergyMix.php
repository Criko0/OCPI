<?php

namespace App\Entity;

use App\Repository\EnergyMixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#mod_locations_energymix_class.
 */
#[ORM\Entity(repositoryClass: EnergyMixRepository::class)]
class EnergyMix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['comment' => 'True if 100% from regenerative sources. (CO2 and nuclear waste is zero)'])]
    private bool $isGreenEnergy;

    /**
     * @var Collection<array-key, EnergySource>
     */
    #[ORM\OneToMany(targetEntity: EnergySource::class, mappedBy: 'energyMix', orphanRemoval: true)]
    private Collection $energySources;

    /**
     * @var Collection<array-key, EnvironmentalImpact>
     */
    #[ORM\OneToMany(targetEntity: EnvironmentalImpact::class, mappedBy: 'energyMix', orphanRemoval: true)]
    private Collection $environImpact;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => 'Name of the energy supplier, delivering the energy for this location or tariff.*'])]
    private ?string $supplierName = null;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => 'Name of the energy suppliers product/tariff plan used at this location.*'])]
    private ?string $energyProductName = null;

    /**
     * @var Collection<array-key, Tariff>
     */
    #[ORM\OneToMany(targetEntity: Tariff::class, mappedBy: 'energyMix')]
    private Collection $tariffs;

    #[ORM\OneToOne(mappedBy: 'energyMix', cascade: ['persist', 'remove'])]
    private ?Location $location = null;

    public function __construct(
        bool $isGreenEnergy,
    ) {
        $this->isGreenEnergy = $isGreenEnergy;
        $this->energySources = new ArrayCollection();
        $this->environImpact = new ArrayCollection();
        $this->tariffs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isGreenEnergy(): bool
    {
        return $this->isGreenEnergy;
    }

    public function setIsGreenEnergy(bool $isGreenEnergy): static
    {
        $this->isGreenEnergy = $isGreenEnergy;

        return $this;
    }

    public function getSupplierName(): ?string
    {
        return $this->supplierName;
    }

    public function setSupplierName(?string $supplierName): static
    {
        $this->supplierName = $supplierName;

        return $this;
    }

    public function getEnergyProductName(): ?string
    {
        return $this->energyProductName;
    }

    public function setEnergyProductName(?string $energyProductName): static
    {
        $this->energyProductName = $energyProductName;

        return $this;
    }

    /**
     * @return Collection<array-key, EnergySource>
     */
    public function getEnergySources(): Collection
    {
        return $this->energySources;
    }

    public function addEnergySource(EnergySource $energySource): static
    {
        if (!$this->energySources->contains($energySource)) {
            $this->energySources->add($energySource);
            $energySource->setEnergyMix($this);
        }

        return $this;
    }

    public function removeEnergySource(EnergySource $energySource): static
    {
        $this->energySources->removeElement($energySource);

        return $this;
    }

    /**
     * @return Collection<array-key, EnvironmentalImpact>
     */
    public function getEnvironImpact(): Collection
    {
        return $this->environImpact;
    }

    public function addEnvironImpact(EnvironmentalImpact $environImpact): static
    {
        if (!$this->environImpact->contains($environImpact)) {
            $this->environImpact->add($environImpact);
            $environImpact->setEnergyMix($this);
        }

        return $this;
    }

    public function removeEnvironImpact(EnvironmentalImpact $environImpact): static
    {
        $this->environImpact->removeElement($environImpact);

        return $this;
    }

    /**
     * @return Collection<array-key, Tariff>
     */
    public function getTariffs(): Collection
    {
        return $this->tariffs;
    }

    public function addTariff(Tariff $tariff): static
    {
        if (!$this->tariffs->contains($tariff)) {
            $this->tariffs->add($tariff);
            $tariff->setEnergyMix($this);
        }

        return $this;
    }

    public function removeTariff(Tariff $tariff): static
    {
        if ($this->tariffs->removeElement($tariff)) {
            // set the owning side to null (unless already changed)
            if ($tariff->getEnergyMix() === $this) {
                $tariff->setEnergyMix(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        // unset the owning side of the relation if necessary
        if (null === $location && null !== $this->location) {
            $this->location->setEnergyMix(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $location && $location->getEnergyMix() !== $this) {
            $location->setEnergyMix($this);
        }

        $this->location = $location;

        return $this;
    }
}
