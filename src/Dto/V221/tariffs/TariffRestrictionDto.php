<?php

namespace App\Dto\V221\tariffs;

use App\Enum\DayOfWeekEnum;
use App\Enum\ReservationRestrictionTypeEnum;
use Symfony\Component\Serializer\Attribute\SerializedName;

class TariffRestrictionDto
{
    #[SerializedName('start_time')]
    public ?string $startTime = null;

    #[SerializedName('end_time')]
    public ?string $endTime = null;

    #[SerializedName('start_date')]
    public ?string $startDate = null;

    #[SerializedName('end_date')]
    public ?string $endDate = null;

    #[SerializedName('min_kwh')]
    public ?float $minKwh = null;

    #[SerializedName('max_kwh')]
    public ?float $maxKwh = null;

    #[SerializedName('min_current')]
    public ?float $minCurrent = null;

    #[SerializedName('max_current')]
    public ?float $maxCurrent = null;

    #[SerializedName('min_power')]
    public ?float $minPower = null;

    #[SerializedName('max_power')]
    public ?float $maxPower = null;

    #[SerializedName('min_duration')]
    public ?int $minDuration = null;

    #[SerializedName('max_duration')]
    public ?int $maxDuration = null;

    /**
     * @var array<array-key, DayOfWeekEnum>|null
     */
    #[SerializedName('day_of_week')]
    public ?array $dayOfWeek = null;

    #[SerializedName('reservation')]
    public ?ReservationRestrictionTypeEnum $reservation = null;
}
