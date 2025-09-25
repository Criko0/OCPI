<?php

namespace App\Dto\V221\tariffs;

use App\Entity\TariffElement;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\ObjectMapper\Transform\MapCollection;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[Map(target: TariffElement::class)]
class TariffElementDto
{
    /**
     * @var array<array-key, PriceComponentDto>
     */
    #[Map(target: 'priceComponent', transform: MapCollection::class)]
    #[SerializedName('price_components')]
    public array $priceComponents = [];

    #[Map(target: 'restrictions')]
    #[SerializedName('restrictions')]
    public ?TariffRestrictionDto $restrictions = null;
}
