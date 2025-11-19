<?php

namespace App\Dto\V221\tariffs;

use App\Enum\TariffDimensionTypeEnum;
use Symfony\Component\Serializer\Attribute\SerializedName;

class PriceComponentDto
{
    #[SerializedName('type')]
    public TariffDimensionTypeEnum $type;

    #[SerializedName('price')]
    public float $price;

    #[SerializedName('vat')]
    public ?float $vat = null;

    #[SerializedName('step_size')]
    public int $stepSize;
}
