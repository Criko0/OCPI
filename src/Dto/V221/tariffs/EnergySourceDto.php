<?php

namespace App\Dto\V221\tariffs;

use App\Enum\EnergySourceCategoryEnum;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;

class EnergySourceDto
{
    #[Map(target: 'source', source: 'source')]
    #[SerializedName('source')]
    public EnergySourceCategoryEnum $source;

    #[Map(target: 'percentage', source: 'percentage')]
    #[SerializedName('percentage')]
    public float $percentage;
}
