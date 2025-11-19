<?php

namespace App\Dto\V221\tariffs;

use App\Dto\V221\DisplayTextDto;
use App\Dto\V221\PriceDto;
use App\Enum\TariffTypeEnum;
use Symfony\Component\Serializer\Attribute\SerializedName;

class TariffDto
{
    #[SerializedName('country_code')]
    public string $countryCode;

    #[SerializedName('party_id')]
    public string $partyId;

    #[SerializedName('id')]
    public string $id;

    #[SerializedName('currency')]
    public string $currency;

    #[SerializedName('type')]
    public ?TariffTypeEnum $type = null;

    /**
     * @var array<array-key, DisplayTextDto>|null
     */
    #[SerializedName('tariff_alt_text')]
    public ?array $tariffAltText = null;

    #[SerializedName('tariff_alt_url')]
    public ?string $tariffAltUrl = null;

    #[SerializedName('min_price')]
    public ?PriceDto $minPrice = null;

    #[SerializedName('max_price')]
    public ?PriceDto $maxPrice = null;

    /**
     * @var array<array-key, TariffElementDto>
     */
    #[SerializedName('elements')]
    public array $elements = [];

    #[SerializedName('start_date_time')]
    public ?\DateTimeImmutable $startDateTime = null;

    #[SerializedName('end_date_time')]
    public ?\DateTimeImmutable $endDateTime = null;

    #[SerializedName('energy_mix')]
    public ?EnergyMixDto $energyMix = null;

    #[SerializedName('last_updated')]
    public \DateTimeImmutable $lastUpdated;
}
