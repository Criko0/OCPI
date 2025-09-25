<?php

namespace App\Entity;

use App\Repository\TariffElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_tariffs.asciidoc#144-tariffelement-class.
 */
#[ORM\Entity(repositoryClass: TariffElementRepository::class)]
class TariffElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<array-key, PriceComponent>
     */
    #[ORM\ManyToMany(targetEntity: PriceComponent::class)]
    private Collection $priceComponent;

    /**
     * @var Collection<array-key, TariffRestrictions>
     */
    #[ORM\OneToMany(targetEntity: TariffRestrictions::class, mappedBy: 'tariffElement')]
    private Collection $restrictions;

    #[ORM\ManyToOne(inversedBy: 'elements')]
    #[ORM\JoinColumn(nullable: false)]
    private Tariff $tariff;

    public function __construct()
    {
        $this->priceComponent = new ArrayCollection();
        $this->restrictions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<array-key, PriceComponent>
     */
    public function getPriceComponent(): Collection
    {
        return $this->priceComponent;
    }

    public function addPriceComponent(PriceComponent $priceComponent): static
    {
        if (!$this->priceComponent->contains($priceComponent)) {
            $this->priceComponent->add($priceComponent);
        }

        return $this;
    }

    public function removePriceComponent(PriceComponent $priceComponent): static
    {
        $this->priceComponent->removeElement($priceComponent);

        return $this;
    }

    /**
     * @return Collection<array-key, TariffRestrictions>
     */
    public function getRestrictions(): Collection
    {
        return $this->restrictions;
    }

    public function addRestriction(TariffRestrictions $restriction): static
    {
        if (!$this->restrictions->contains($restriction)) {
            $this->restrictions->add($restriction);
            $restriction->setTariffElement($this);
        }

        return $this;
    }

    public function removeRestriction(TariffRestrictions $restriction): static
    {
        if ($this->restrictions->removeElement($restriction)) {
            // set the owning side to null (unless already changed)
            if ($restriction->getTariffElement() === $this) {
                $restriction->setTariffElement(null);
            }
        }

        return $this;
    }

    public function getTariff(): Tariff
    {
        return $this->tariff;
    }

    public function setTariff(Tariff $tariff): static
    {
        $this->tariff = $tariff;

        return $this;
    }
}
