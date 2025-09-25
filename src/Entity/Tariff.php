<?php

namespace App\Entity;

use App\Enum\TariffTypeEnum;
use App\Repository\TariffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_tariffs.asciidoc#mod_tariffs_tariff_object.
 */
#[ORM\Entity(repositoryClass: TariffRepository::class)]
class Tariff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2, options: ['comment' => 'ISO-3166 alpha-2 country code of the CPO that owns this Tariff.'])]
    private string $countryCode;

    #[ORM\Column(length: 3, options: ['comment' => 'ID of the CPO that `owns` this Tariff (following the ISO-15118 standard).'])]
    private string $partyId;

    #[ORM\Column(length: 36, options: ['comment' => 'Uniquely identifies the tariff within the CPO’s platform (and suboperator platforms).'])]
    private string $tariffId;

    #[ORM\Column(length: 3, options: ['comment' => 'ISO-4217 code of the currency of this tariff.'])]
    private string $currency;

    #[ORM\Column(nullable: true, enumType: TariffTypeEnum::class, options: ['comment' => 'Defines the type of the tariff. This allows for distinction in case of given Charging Preferences. When omitted, this tariff is valid for all sessions.'])]
    private ?TariffTypeEnum $type = null;

    /**
     * @var Collection<array-key, DisplayText>
     */
    #[ORM\JoinTable(
        name: 'tariff_display_text',
        joinColumns: [new ORM\JoinColumn(name: 'tariff_id', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'display_text_id', referencedColumnName: 'id')]
    )]
    #[ORM\ManyToMany(targetEntity: DisplayText::class)]
    private Collection $tariffAltText;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => 'URL to a web page that contains an explanation of the tariff information in human readable form.'])]
    private ?string $tariffAltUrl = null;

    #[Embedded(class: Price::class, columnPrefix: 'min_price')]
    private ?Price $minPrice;

    #[Embedded(class: Price::class, columnPrefix: 'max_price')]
    private ?Price $maxPrice;

    /**
     * @var Collection<array-key, TariffElement>
     */
    #[ORM\OneToMany(targetEntity: TariffElement::class, mappedBy: 'tariff', orphanRemoval: true)]
    private Collection $elements;

    #[ORM\Column(nullable: true, options: ['comment' => 'The time when this tariff becomes active, in UTC, time_zone field of the Location can be used to convert to local time. Typically used for a new tariff that is already given with the location, before it becomes active.'])]
    private ?\DateTimeImmutable $startDateTime = null;

    #[ORM\Column(nullable: true, options: ['comment' => 'The time after which this tariff is no longer valid, in UTC, time_zone field if the Location can be used to convert to local time. Typically used when this tariff is going to be replaced with a different tariff in the near future.'])]
    private ?\DateTimeImmutable $endDateTime = null;

    #[ORM\ManyToOne(inversedBy: 'tariffs')]
    private ?EnergyMix $energyMix = null;

    #[ORM\Column(options: ['comment' => 'Timestamp when this Tariff was last updated (or created).'])]
    private \DateTimeImmutable $lastUpdated;

    /**
     * @var Collection<array-key, Connector>
     */
    #[ORM\ManyToMany(targetEntity: Connector::class, mappedBy: 'tariffs')]
    private Collection $connectors;

    public function __construct()
    {
        $this->tariffAltText = new ArrayCollection();
        $this->elements = new ArrayCollection();
        $this->connectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function setPartyId(string $partyId): static
    {
        $this->partyId = $partyId;

        return $this;
    }

    public function getTariffId(): string
    {
        return $this->tariffId;
    }

    public function setTariffId(string $tariffId): static
    {
        $this->tariffId = $tariffId;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getType(): ?TariffTypeEnum
    {
        return $this->type;
    }

    public function setType(?TariffTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<array-key, DisplayText>
     */
    public function getTariffAltText(): Collection
    {
        return $this->tariffAltText;
    }

    public function addTariffAltText(DisplayText $tariffAltText): static
    {
        if (!$this->tariffAltText->contains($tariffAltText)) {
            $this->tariffAltText->add($tariffAltText);
        }

        return $this;
    }

    public function removeTariffAltText(DisplayText $tariffAltText): static
    {
        $this->tariffAltText->removeElement($tariffAltText);

        return $this;
    }

    public function getTariffAltUrl(): ?string
    {
        return $this->tariffAltUrl;
    }

    public function setTariffAltUrl(?string $tariffAltUrl): static
    {
        $this->tariffAltUrl = $tariffAltUrl;

        return $this;
    }

    public function getMinPrice(): Price
    {
        return $this->minPrice;
    }

    public function setMinPrice(Price $minPrice): static
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    public function getMaxPrice(): Price
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(Price $maxPrice): static
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * @return Collection<array-key, TariffElement>
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function addElement(TariffElement $element): static
    {
        if (!$this->elements->contains($element)) {
            $this->elements->add($element);
            $element->setTariff($this);
        }

        return $this;
    }

    public function removeElement(TariffElement $element): static
    {
        $this->elements->removeElement($element);

        return $this;
    }

    public function getStartDateTime(): ?\DateTimeImmutable
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(?\DateTimeImmutable $startDateTime): static
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeImmutable
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?\DateTimeImmutable $endDateTime): static
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function setEnergyMix(?EnergyMix $energyMix): static
    {
        $this->energyMix = $energyMix;

        return $this;
    }

    public function getLastUpdated(): \DateTimeImmutable
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(\DateTimeImmutable $lastUpdated): static
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * @return Collection<array-key, Connector>
     */
    public function getConnectors(): Collection
    {
        return $this->connectors;
    }

    public function addConnector(Connector $connector): static
    {
        if (!$this->connectors->contains($connector)) {
            $this->connectors->add($connector);
            $connector->addTariff($this);
        }

        return $this;
    }

    public function removeConnector(Connector $connector): static
    {
        if ($this->connectors->removeElement($connector)) {
            $connector->removeTariff($this);
        }

        return $this;
    }
}
