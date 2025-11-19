<?php

namespace App\Dto\V221\tariffs;

use App\Enum\EnvironmentalImpactCategoryEnum;
use Symfony\Component\Serializer\Attribute\SerializedName;

class EnvironmentalImpactDto
{
    #[SerializedName('category')]
    public EnvironmentalImpactCategoryEnum $category;

    #[SerializedName('amount')]
    public float $amount;
}
