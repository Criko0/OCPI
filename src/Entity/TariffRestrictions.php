<?php

namespace App\Entity;

use App\Enum\DayOfWeekEnum;
use App\Enum\ReservationRestrictionTypeEnum;
use App\Repository\TariffRestrictionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_tariffs.asciidoc#mod_tariffs_tariffrestrictions_class.
 */
#[ORM\Entity(repositoryClass: TariffRestrictionsRepository::class)]
class TariffRestrictions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5, nullable: true, options: ['comment' => 'Start time of day in local time, the time zone is defined in the time_zone field of the Location, for example 13:30, valid from this time of the day. Must be in 24h format with leading zeros. Hour/Minute separator: ":" Regex: ([0-1][0-9]|2[0-3]):[0-5][0-9]'])]
    private ?string $startTime = null;

    #[ORM\Column(length: 5, nullable: true, options: ['comment' => 'End time of day in local time, the time zone is defined in the time_zone field of the Location, for example 19:45, valid until this time of the day. Same syntax as start_time. If end_time < start_time then the period wraps around to the next day. To stop at end of the day use: 00:00.'])]
    private ?string $endTime = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true, options: ['comment' => 'Start date in local time, the time zone is defined in the time_zone field of the Location, for example: 2015-12-24, valid from this day (inclusive). Regex: ([12][0-9]{3})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])'])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true, options: ['comment' => 'End date in local time, the time zone is defined in the time_zone field of the Location, for example: 2015-12-27, valid until this day (exclusive). Same syntax as start_date.'])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Minimum consumed energy in kWh, for example 20, valid from this amount of energy (inclusive) being used.'])]
    private ?string $minKwh = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Maximum consumed energy in kWh, for example 50, valid until this amount of energy (exclusive) being used.'])]
    private ?string $maxKwh = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Sum of the minimum current (in Amperes) over all phases, for example 5. When the EV is charging with more than, or equal to, the defined amount of current, this TariffElement is/becomes active. If the charging current is or becomes lower, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the minimum current over the entire Charging Session. This restriction can make a TariffElement become active when the charging current is above the defined value, but the TariffElement MUST no longer be active when the charging current drops below the defined value.'])]
    private ?string $minCurrent = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Sum of the maximum current (in Amperes) over all phases, for example 20. When the EV is charging with less than the defined amount of current, this TariffElement becomes/is active. If the charging current is or becomes higher, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the maximum current over the entire Charging Session. This restriction can make a TariffElement become active when the charging current is below this value, but the TariffElement MUST no longer be active when the charging current raises above the defined value.'])]
    private ?string $maxCurrent = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Minimum power in kW, for example 5. When the EV is charging with more than, or equal to, the defined amount of power, this TariffElement is/becomes active. If the charging power is or becomes lower, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the minimum power over the entire Charging Session. This restriction can make a TariffElement become active when the charging power is above this value, but the TariffElement MUST no longer be active when the charging power drops below the defined value.'])]
    private ?string $minPower = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Maximum power in kW, for example 20. When the EV is charging with less than the defined amount of power, this TariffElement becomes/is active. If the charging power is or becomes higher, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the maximum power over the entire Charging Session. This restriction can make a TariffElement become active when the charging power is below this value, but the TariffElement MUST no longer be active when the charging power raises above the defined value.'])]
    private ?string $maxPower = null;

    #[ORM\Column(nullable: true, options: ['comment' => 'Minimum duration in seconds the Charging Session MUST last (inclusive). When the duration of a Charging Session is longer than the defined value, this TariffElement is or becomes active. Before that moment, this TariffElement is not yet active.'])]
    private ?int $minDuration = null;

    #[ORM\Column(nullable: true, options: ['comment' => 'Maximum duration in seconds the Charging Session MUST last (exclusive). When the duration of a Charging Session is shorter than the defined value, this TariffElement is or becomes active. After that moment, this TariffElement is no longer active.'])]
    private ?int $maxDuration = null;

    /**
     * @var array<array-key, DayOfWeekEnum>
     */
    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: DayOfWeekEnum::class, options: ['comment' => 'Which day(s) of the week this TariffElement is active.'])]
    private ?array $dayOfWeek = null;

    #[ORM\Column(nullable: true, enumType: ReservationRestrictionTypeEnum::class, options: ['comment' => 'When this field is present, the TariffElement describes reservation costs. A reservation starts when the reservation is made, and ends when the driver starts charging on the reserved EVSE/Location, or when the reservation expires. A reservation can only have: FLAT and TIME TariffDimensions, where TIME is for the duration of the reservation.'])]
    private ?ReservationRestrictionTypeEnum $reservation = null;

    #[ORM\ManyToOne(inversedBy: 'restrictions')]
    private ?TariffElement $tariffElement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(?string $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function setEndTime(?string $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getMinKwh(): ?string
    {
        return $this->minKwh;
    }

    public function setMinKwh(?string $minKwh): static
    {
        $this->minKwh = $minKwh;

        return $this;
    }

    public function getMaxKwh(): ?string
    {
        return $this->maxKwh;
    }

    public function setMaxKwh(?string $maxKwh): static
    {
        $this->maxKwh = $maxKwh;

        return $this;
    }

    public function getMinCurrent(): ?string
    {
        return $this->minCurrent;
    }

    public function setMinCurrent(?string $minCurrent): static
    {
        $this->minCurrent = $minCurrent;

        return $this;
    }

    public function getMaxCurrent(): ?string
    {
        return $this->maxCurrent;
    }

    public function setMaxCurrent(?string $maxCurrent): static
    {
        $this->maxCurrent = $maxCurrent;

        return $this;
    }

    public function getMinPower(): ?string
    {
        return $this->minPower;
    }

    public function setMinPower(?string $minPower): static
    {
        $this->minPower = $minPower;

        return $this;
    }

    public function getMaxPower(): ?string
    {
        return $this->maxPower;
    }

    public function setMaxPower(?string $maxPower): static
    {
        $this->maxPower = $maxPower;

        return $this;
    }

    public function getMinDuration(): ?int
    {
        return $this->minDuration;
    }

    public function setMinDuration(?int $minDuration): static
    {
        $this->minDuration = $minDuration;

        return $this;
    }

    public function getMaxDuration(): ?int
    {
        return $this->maxDuration;
    }

    public function setMaxDuration(?int $maxDuration): static
    {
        $this->maxDuration = $maxDuration;

        return $this;
    }

    /**
     * @return array<array-key, DayOfWeekEnum>|null
     */
    public function getDayOfWeek(): ?array
    {
        return $this->dayOfWeek;
    }

    /**
     * @param array<array-key, DayOfWeekEnum>|null $dayOfWeek
     */
    public function setDayOfWeek(?array $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getReservation(): ?ReservationRestrictionTypeEnum
    {
        return $this->reservation;
    }

    public function setReservation(?ReservationRestrictionTypeEnum $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getTariffElement(): ?TariffElement
    {
        return $this->tariffElement;
    }

    public function setTariffElement(?TariffElement $tariffElement): static
    {
        $this->tariffElement = $tariffElement;

        return $this;
    }
}
