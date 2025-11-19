<?php

namespace App\Dto\V221\tariffs;

use App\Enum\EnergySourceCategoryEnum;
use Symfony\Component\Serializer\Attribute\SerializedName;

class EnergySourceDto
{
    #[SerializedName('source')]
    public EnergySourceCategoryEnum $source;

    #[SerializedName('percentage')]
    public float $percentage;
}
