<?php

namespace App\Dto\V221\tariffs;

use App\Entity\PriceComponent;
use App\Enum\TariffDimensionTypeEnum;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[Map(target: PriceComponent::class)]
class PriceComponentDto
{
    #[Map(target: 'type')]
    #[SerializedName('type')]
    public TariffDimensionTypeEnum $type;

    #[Map(target: 'price')]
    #[SerializedName('price')]
    public float $price;

    #[Map(target: 'vat', if: 'is_numeric', transform: 'strval')]
    #[SerializedName('vat')]
    public ?float $vat = null;

    #[Map(target: 'stepSize')]
    #[SerializedName('step_size')]
    public int $stepSize;
}
