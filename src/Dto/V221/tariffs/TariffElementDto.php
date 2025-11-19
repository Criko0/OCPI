<?php

namespace App\Dto\V221\tariffs;

use Symfony\Component\Serializer\Attribute\SerializedName;

class TariffElementDto
{
    /**
     * @var array<array-key, PriceComponentDto>
     */
    #[SerializedName('price_components')]
    public array $priceComponents = [];

    #[SerializedName('restrictions')]
    public ?TariffRestrictionDto $restrictions = null;
}
