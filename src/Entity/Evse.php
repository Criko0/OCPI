<?php

namespace App\Entity;

use App\Enum\CapabilityEnum;
use App\Enum\ParkingRestrictionEnum;
use App\Enum\StatusEnum;
use App\Repository\EvseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#132-evse-object.
 */
#[ORM\Entity(repositoryClass: EvseRepository::class)]
class Evse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
        length: 36,
        options: ['comment' => 'Uniquely identifies the EVSE within the CPOs platform (and suboperator platforms). This field can never be changed, modified or renamed. This is the `technical` identification of the EVSE, not to be used as `human readable` identification, use the field evse_id for that. This field is named uid instead of id, because id could be confused with evse_id which is an eMI3 defined field. Note that in order to fulfill both the requirement that an EVSE’s uid be unique within a CPO’s platform and the requirement that EVSEs are never deleted, a CPO will typically want to avoid using identifiers of the physical hardware for this uid property. If they do use such a physical identifier, they will find themselves breaking the uniqueness requirement for uid when the same physical EVSE is redeployed at another Location.']
    )]
    private string $uid;

    #[ORM\Column(
        length: 48,
        nullable: true,
        options: ['comment' => 'Compliant with the following specification for EVSE ID from "eMI3 standard version V1.0" (https://web.archive.org/web/20230603153631/https://emi3group.com/documents-links/) "Part 2: business objects." Optional because: if an evse_id is to be re-used in the real world, the evse_id can be removed from an EVSE object if the status is set to REMOVED.']
    )]
    private ?string $evseId = null;

    #[ORM\Column(
        enumType: StatusEnum::class,
        options: ['comment' => 'Indicates the current status of the EVSE.']
    )]
    private StatusEnum $status;

    /**
     * @var Collection<array-key, StatusSchedule>
     */
    #[ORM\OneToMany(targetEntity: StatusSchedule::class, mappedBy: 'evse', orphanRemoval: true)]
    private Collection $statusSchedule;

    /**
     * @var array<array-key, CapabilityEnum>
     */
    #[ORM\Column(
        type: Types::SIMPLE_ARRAY,
        nullable: true,
        enumType: CapabilityEnum::class,
        options: ['comment' => 'List of functionalities that the EVSE is capable of.']
    )]
    private ?array $capabilities = null;

    /**
     * @var Collection<array-key, Connector>
     */
    #[ORM\OneToMany(targetEntity: Connector::class, mappedBy: 'evse', orphanRemoval: true)]
    private Collection $connectors;

    #[ORM\Column(
        length: 4,
        nullable: true,
        options: ['comment' => 'Level on which the Charge Point is located (in garage buildings) in the locally displayed numbering scheme.']
    )]
    private ?string $floorLevel = null;

    #[Embedded(class: GeoLocation::class, columnPrefix: false)]
    private ?GeoLocation $coordinates = null;

    #[ORM\Column(length: 16, nullable: true, options: ['comment' => 'A number/string printed on the outside of the EVSE for visual identification.'])]
    private ?string $physicalReference = null;

    /**
     * @var Collection<array-key, DisplayText>
     */
    #[ORM\ManyToMany(targetEntity: DisplayText::class)]
    private Collection $directions;

    /**
     * @var array<array-key, ParkingRestrictionEnum>
     */
    #[ORM\Column(
        type: Types::SIMPLE_ARRAY,
        nullable: true,
        enumType: ParkingRestrictionEnum::class,
        options: ['comment' => 'The restrictions that apply to the parking spot.']
    )]
    private ?array $parkingRestrictions = null;

    /**
     * @var Collection<array-key, Image>
     */
    #[ORM\ManyToMany(targetEntity: Image::class)]
    private Collection $images;

    #[ORM\Column(options: ['comment' => 'Timestamp when this EVSE or one of its Connectors was last updated (or created).'])]
    private \DateTimeImmutable $lastUpdated;

    #[ORM\ManyToOne(inversedBy: 'evses')]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    public function __construct(
        string $uid,
        StatusEnum $status,
        \DateTimeImmutable $lastUpdated,
    ) {
        $this->uid = $uid;
        $this->status = $status;
        $this->lastUpdated = $lastUpdated;
        $this->statusSchedule = new ArrayCollection();
        $this->connectors = new ArrayCollection();
        $this->directions = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getEvseId(): ?string
    {
        return $this->evseId;
    }

    public function setEvseId(?string $evseId): static
    {
        $this->evseId = $evseId;

        return $this;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<array-key, StatusSchedule>
     */
    public function getStatusSchedule(): Collection
    {
        return $this->statusSchedule;
    }

    public function addStatusSchedule(StatusSchedule $statusSchedule): static
    {
        if (!$this->statusSchedule->contains($statusSchedule)) {
            $this->statusSchedule->add($statusSchedule);
            $statusSchedule->setEvse($this);
        }

        return $this;
    }

    public function removeStatusSchedule(StatusSchedule $statusSchedule): static
    {
        $this->statusSchedule->removeElement($statusSchedule);

        return $this;
    }

    /**
     * @return array<array-key, CapabilityEnum>|null
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    /**
     * @param array<array-key, CapabilityEnum>|null $capabilities
     */
    public function setCapabilities(?array $capabilities): static
    {
        $this->capabilities = $capabilities;

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
            $connector->setEvse($this);
        }

        return $this;
    }

    public function removeConnector(Connector $connector): static
    {
        if ($this->connectors->removeElement($connector)) {
            // set the owning side to null (unless already changed)
            if ($connector->getEvse() === $this) {
                $connector->setEvse(null);
            }
        }

        return $this;
    }

    public function getFloorLevel(): ?string
    {
        return $this->floorLevel;
    }

    public function setFloorLevel(?string $floorLevel): static
    {
        $this->floorLevel = $floorLevel;

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

    public function getPhysicalReference(): ?string
    {
        return $this->physicalReference;
    }

    public function setPhysicalReference(?string $physicalReference): static
    {
        $this->physicalReference = $physicalReference;

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

    /**
     * @return array<array-key, ParkingRestrictionEnum>|null $capabilities
     */
    public function getParkingRestrictions(): ?array
    {
        return $this->parkingRestrictions;
    }

    /**
     * @param array<array-key, ParkingRestrictionEnum>|null $parkingRestrictions
     */
    public function setParkingRestrictions(?array $parkingRestrictions): static
    {
        $this->parkingRestrictions = $parkingRestrictions;

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
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        $this->images->removeElement($image);

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
