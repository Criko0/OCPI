<?php

namespace App\Dto\V221;

use App\Entity\DisplayText;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[Map(target: DisplayText::class)]
class DisplayTextDto
{
    #[Map(target: 'language')]
    #[SerializedName('language')]
    public string $language;

    #[Map(target: 'text')]
    #[SerializedName('text')]
    public string $text;
}
