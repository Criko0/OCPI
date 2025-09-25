<?php

namespace App\Dto\V221;

use App\Entity\Price;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[Map(target: Price::class)]
class PriceDto
{
    #[Map(target: 'exclVat')]
    #[SerializedName('excl_vat')]
    public float $exclVat;

    #[Map(target: 'inclVat')]
    #[SerializedName('incl_vat')]
    public float $inclVat;
}
