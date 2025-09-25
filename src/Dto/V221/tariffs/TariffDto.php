<?php

namespace App\Dto\V221\tariffs;

use App\Dto\V221\DisplayTextDto;
use App\Dto\V221\PriceDto;
use App\Entity\Tariff;
use App\Enum\TariffTypeEnum;
use App\Util\Util;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\ObjectMapper\Transform\MapCollection;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[Map(target: Tariff::class)]
class TariffDto
{
    #[Map(target: 'countryCode')]
    #[SerializedName('country_code')]
    public string $countryCode;

    #[Map(target: 'partyId')]
    #[SerializedName('party_id')]
    public string $partyId;

    #[Map(target: 'tariffId')]
    #[SerializedName('id')]
    public string $id;

    #[Map(target: 'currency')]
    #[SerializedName('currency')]
    public string $currency;

    #[Map(target: 'type')]
    #[SerializedName('type')]
    public ?TariffTypeEnum $type = null;

    /**
     * @var array<array-key, DisplayTextDto>|null
     */
    #[Map(target: 'tariffAltText', if: [Util::class, 'iterableIsNotEmpty'], transform: MapCollection::class)]
    #[SerializedName('tariff_alt_text')]
    public ?array $tariffAltText = null;

    #[Map(target: 'tariffAltUrl')]
    #[SerializedName('tariff_alt_url')]
    public ?string $tariffAltUrl = null;

    #[Map(target: 'minPrice', if: [Util::class, 'isNotNull'])]
    #[SerializedName('min_price')]
    public ?PriceDto $minPrice = null;

    #[Map(target: 'maxPrice', if: [Util::class, 'isNotNull'])]
    #[SerializedName('max_price')]
    public ?PriceDto $maxPrice = null;

    /**
     * @var array<array-key, TariffElementDto>
     */
    #[Map(target: 'elements', transform: MapCollection::class)]
    #[SerializedName('elements')]
    public array $elements = [];

    #[Map(target: 'startDateTime')]
    #[SerializedName('start_date_time')]
    public ?\DateTimeImmutable $startDateTime = null;

    #[Map(target: 'endDateTime')]
    #[SerializedName('end_date_time')]
    public ?\DateTimeImmutable $endDateTime = null;

    #[Map(target: 'energyMix')]
    #[SerializedName('energy_mix')]
    public ?EnergyMixDto $energyMix = null;

    #[Map(target: 'lastUpdated')]
    #[SerializedName('last_updated')]
    public \DateTimeImmutable $lastUpdated;
}
