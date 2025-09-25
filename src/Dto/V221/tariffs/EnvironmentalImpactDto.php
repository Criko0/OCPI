<?php

namespace App\Dto\V221\tariffs;

use App\Enum\EnvironmentalImpactCategoryEnum;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;

class EnvironmentalImpactDto
{
    #[Map(target: 'category')]
    #[SerializedName('category')]
    public EnvironmentalImpactCategoryEnum $category;

    #[Map(target: 'amount')]
    #[SerializedName('amount')]
    public float $amount;
}
