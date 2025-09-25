<?php

namespace App\Entity;

use App\Enum\FacilityEnum;
use App\Enum\ParkingTypeEnum;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2)]
    private string $countryCode;

    #[ORM\Column(length: 3)]
    private string $partyId;

    #[ORM\Column(length: 36)]
    private string $locationId;

    #[ORM\Column]
    private bool $publish;

    /**
     * @var Collection<array-key, PublishTokenType>
     */
    #[ORM\OneToMany(targetEntity: PublishTokenType::class, mappedBy: 'location', orphanRemoval: true)]
    private Collection $publishAllowedTo;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    private string $addres;

    #[ORM\Column(length: 45)]
    private string $city;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 3)]
    private string $country;

    #[Embedded(class: GeoLocation::class, columnPrefix: false)]
    private GeoLocation $coordinates;

    /**
     * @var Collection<array-key, AdditionalGeoLocation>
     */
    #[ORM\OneToMany(targetEntity: AdditionalGeoLocation::class, mappedBy: 'location', orphanRemoval: true)]
    private Collection $relatedLocations;

    #[ORM\Column(nullable: true, enumType: ParkingTypeEnum::class)]
    private ?ParkingTypeEnum $parkingType = null;

    /**
     * @var Collection<array-key, Evse>
     */
    #[ORM\OneToMany(targetEntity: Evse::class, mappedBy: 'location', orphanRemoval: true)]
    private Collection $evses;

    /**
     * @var Collection<array-key, DisplayText>
     */
    #[ORM\ManyToMany(targetEntity: DisplayText::class)]
    private Collection $directions;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?BusinessDetails $operator = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?BusinessDetails $suboperator = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?BusinessDetails $owner = null;

    /**
     * @var array<array-key, FacilityEnum>
     */
    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: FacilityEnum::class)]
    private ?array $facilities = null;

    #[ORM\Column(length: 255)]
    private string $timeZone;

    #[ORM\OneToOne(inversedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Hours $openingTimes = null;

    #[ORM\Column(nullable: true)]
    private ?bool $chargingWhenClosed = null;

    /**
     * @var Collection<array-key, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'location')]
    private Collection $images;

    #[ORM\OneToOne(inversedBy: 'location', cascade: ['persist', 'remove'])]
    private ?EnergyMix $energyMix = null;

    #[ORM\Column]
    private \DateTimeImmutable $lastUpdated;

    public function __construct(
        string $countryCode,
        string $partyId,
        string $locationId,
        bool $publish,
        string $addres,
        string $city,
        string $country,
        GeoLocation $coordinates,
        string $timeZone,
        \DateTimeImmutable $lastUpdated,
    ) {
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->locationId = $locationId;
        $this->publish = $publish;
        $this->addres = $addres;
        $this->city = $city;
        $this->country = $country;
        $this->coordinates = $coordinates;
        $this->timeZone = $timeZone;
        $this->lastUpdated = $lastUpdated;
        $this->publishAllowedTo = new ArrayCollection();
        $this->relatedLocations = new ArrayCollection();
        $this->evses = new ArrayCollection();
        $this->directions = new ArrayCollection();
        $this->images = new ArrayCollection();
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

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function setLocationId(string $locationId): static
    {
        $this->locationId = $locationId;

        return $this;
    }

    public function isPublish(): bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): static
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * @return Collection<array-key, PublishTokenType>
     */
    public function getPublishAllowedTo(): Collection
    {
        return $this->publishAllowedTo;
    }

    public function addPublishAllowedTo(PublishTokenType $publishAllowedTo): static
    {
        if (!$this->publishAllowedTo->contains($publishAllowedTo)) {
            $this->publishAllowedTo->add($publishAllowedTo);
            $publishAllowedTo->setLocation($this);
        }

        return $this;
    }

    public function removePublishAllowedTo(PublishTokenType $publishAllowedTo): static
    {
        $this->publishAllowedTo->removeElement($publishAllowedTo);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddres(): string
    {
        return $this->addres;
    }

    public function setAddres(string $addres): static
    {
        $this->addres = $addres;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCoordinates(): GeoLocation
    {
        return $this->coordinates;
    }

    public function setCoordinates(GeoLocation $coordinates): static
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * @return Collection<array-key, AdditionalGeoLocation>
     */
    public function getRelatedLocations(): Collection
    {
        return $this->relatedLocations;
    }

    public function addRelatedLocation(AdditionalGeoLocation $relatedLocation): static
    {
        if (!$this->relatedLocations->contains($relatedLocation)) {
            $this->relatedLocations->add($relatedLocation);
            $relatedLocation->setLocation($this);
        }

        return $this;
    }

    public function removeRelatedLocation(AdditionalGeoLocation $relatedLocation): static
    {
        $this->relatedLocations->removeElement($relatedLocation);

        return $this;
    }

    public function getParkingType(): ?ParkingTypeEnum
    {
        return $this->parkingType;
    }

    public function setParkingType(?ParkingTypeEnum $parkingType): static
    {
        $this->parkingType = $parkingType;

        return $this;
    }

    /**
     * @return Collection<array-key, Evse>
     */
    public function getEvses(): Collection
    {
        return $this->evses;
    }

    public function addEvse(Evse $evse): static
    {
        if (!$this->evses->contains($evse)) {
            $this->evses->add($evse);
            $evse->setLocation($this);
        }

        return $this;
    }

    public function removeEvse(Evse $evse): static
    {
        if ($this->evses->removeElement($evse)) {
            // set the owning side to null (unless already changed)
            if ($evse->getLocation() === $this) {
                $evse->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<array-key, DisplayText>
     */
    public function getDirections(): Collection
    {
        return $this->directions;
    }

    public function addDirection(DisplayText $direction): static
    {
        if (!$this->directions->contains($direction)) {
            $this->directions->add($direction);
        }

        return $this;
    }

    public function removeDirection(DisplayText $direction): static
    {
        $this->directions->removeElement($direction);

        return $this;
    }

    public function getOperator(): ?BusinessDetails
    {
        return $this->operator;
    }

    public function setOperator(?BusinessDetails $operator): static
    {
        $this->operator = $operator;

        return $this;
    }

    public function getSuboperator(): ?BusinessDetails
    {
        return $this->suboperator;
    }

    public function setSuboperator(?BusinessDetails $suboperator): static
    {
        $this->suboperator = $suboperator;

        return $this;
    }

    public function getOwner(): ?BusinessDetails
    {
        return $this->owner;
    }

    public function setOwner(?BusinessDetails $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return array<array-key, FacilityEnum>|null
     */
    public function getFacilities(): ?array
    {
        return $this->facilities;
    }

    /**
     * @param array<array-key, FacilityEnum>|null $facilities
     */
    public function setFacilities(?array $facilities): static
    {
        $this->facilities = $facilities;

        return $this;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): static
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    public function getOpeningTimes(): ?Hours
    {
        return $this->openingTimes;
    }

    public function setOpeningTimes(?Hours $openingTimes): static
    {
        $this->openingTimes = $openingTimes;

        return $this;
    }

    public function isChargingWhenClosed(): ?bool
    {
        return $this->chargingWhenClosed;
    }

    public function setChargingWhenClosed(?bool $chargingWhenClosed): static
    {
        $this->chargingWhenClosed = $chargingWhenClosed;

        return $this;
    }

    /**
     * @return Collection<array-key, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setLocation($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getLocation() === $this) {
                $image->setLocation(null);
            }
        }

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
}
