<?php

namespace App\Entity;

use App\Enum\ConnectorFormatEnum;
use App\Enum\ConnectorTypeEnum;
use App\Enum\PowerTypeEnum;
use App\Repository\ConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectorRepository::class)]
class Connector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
        length: 36,
        options: ['comment' => 'Identifier of the Connector within the EVSE. Two Connectors may have the same id as long as they do not belong to the same EVSE object.']
    )]
    private string $connectorId;

    #[ORM\Column(
        enumType: ConnectorTypeEnum::class,
        options: ['comment' => 'The standard of the installed connector.']
    )]
    private ConnectorTypeEnum $standard;

    #[ORM\Column(
        enumType: ConnectorFormatEnum::class,
        options: ['comment' => 'The format (socket/cable) of the installed connector.']
    )]
    private ConnectorFormatEnum $format;

    #[ORM\Column(enumType: PowerTypeEnum::class)]
    private PowerTypeEnum $powerType;

    #[ORM\Column(options: ['comment' => 'Maximum voltage of the connector (line to neutral for AC_3_PHASE), in volt [V]. For example: DC Chargers might vary the voltage during charging when battery almost full.'])]
    private int $maxVoltage;

    #[ORM\Column(options: ['comment' => 'Maximum amperage of the connector, in ampere [A].'])]
    private int $maxAmperage;

    #[ORM\Column(
        nullable: true,
        options: ['comment' => 'Maximum electric power that can be delivered by this connector, in Watts (W). When the maximum electric power is lower than the calculated value from voltage and amperage, this value should be set. For example: A DC Charge Point which can delivers up to 920V and up to 400A can be limited to a maximum of 150kW (max_electric_power = 150000). Depending on the car, it may supply max voltage or current, but not both at the same time. For AC Charge Points, the amount of phases used can also have influence on the maximum power.']
    )]
    private ?int $maxElectricPower = null;

    /**
     * @var Collection<array-key, Tariff>
     */
    #[ORM\ManyToMany(targetEntity: Tariff::class, inversedBy: 'connectors')]
    private Collection $tariffs;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => 'URL to the operator’s terms and conditions.'])]
    private ?string $termsAndConditions = null;

    #[ORM\Column(options: ['comment' => 'Timestamp when this Connector was last updated (or created).'])]
    private \DateTimeImmutable $lastUpdated;

    #[ORM\ManyToOne(inversedBy: 'connectors')]
    #[ORM\JoinColumn(nullable: false)]
    private Evse $evse;

    public function __construct(
        string $connectorId,
        ConnectorTypeEnum $standard,
        ConnectorFormatEnum $format,
        PowerTypeEnum $powerType,
        int $maxVoltage,
        int $maxAmperage,
        \DateTimeImmutable $lastUpdated,
        Evse $evse,
    ) {
        $this->connectorId = $connectorId;
        $this->standard = $standard;
        $this->format = $format;
        $this->powerType = $powerType;
        $this->maxVoltage = $maxVoltage;
        $this->maxAmperage = $maxAmperage;
        $this->tariffs = new ArrayCollection();
        $this->lastUpdated = $lastUpdated;
        $this->evse = $evse;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }

    public function setConnectorId(string $connectorId): static
    {
        $this->connectorId = $connectorId;

        return $this;
    }

    public function getStandard(): ConnectorTypeEnum
    {
        return $this->standard;
    }

    public function setStandard(ConnectorTypeEnum $standard): static
    {
        $this->standard = $standard;

        return $this;
    }

    public function getFormat(): ConnectorFormatEnum
    {
        return $this->format;
    }

    public function setFormat(ConnectorFormatEnum $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getPowerType(): PowerTypeEnum
    {
        return $this->powerType;
    }

    public function setPowerType(PowerTypeEnum $powerType): static
    {
        $this->powerType = $powerType;

        return $this;
    }

    public function getMaxVoltage(): int
    {
        return $this->maxVoltage;
    }

    public function setMaxVoltage(int $maxVoltage): static
    {
        $this->maxVoltage = $maxVoltage;

        return $this;
    }

    public function getMaxAmperage(): int
    {
        return $this->maxAmperage;
    }

    public function setMaxAmperage(int $maxAmperage): static
    {
        $this->maxAmperage = $maxAmperage;

        return $this;
    }

    public function getMaxElectricPower(): ?int
    {
        return $this->maxElectricPower;
    }

    public function setMaxElectricPower(?int $maxElectricPower): static
    {
        $this->maxElectricPower = $maxElectricPower;

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
        }

        return $this;
    }

    public function removeTariff(Tariff $tariff): static
    {
        $this->tariffs->removeElement($tariff);

        return $this;
    }

    public function getTermsAndConditions(): ?string
    {
        return $this->termsAndConditions;
    }

    public function setTermsAndConditions(?string $termsAndConditions): static
    {
        $this->termsAndConditions = $termsAndConditions;

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

    public function getEvse(): ?Evse
    {
        return $this->evse;
    }

    public function setEvse(?Evse $evse): static
    {
        $this->evse = $evse;

        return $this;
    }
}
