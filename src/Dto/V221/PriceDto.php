<?php

namespace App\Dto\V221;

use Symfony\Component\Serializer\Annotation\SerializedName;

class PriceDto
{
    #[SerializedName('excl_vat')]
    public float $exclVat;

    #[SerializedName('incl_vat')]
    public float $inclVat;
}
