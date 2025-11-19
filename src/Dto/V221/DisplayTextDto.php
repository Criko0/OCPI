<?php

namespace App\Dto\V221;

use Symfony\Component\Serializer\Attribute\SerializedName;

class DisplayTextDto
{
    #[SerializedName('language')]
    public string $language;

    #[SerializedName('text')]
    public string $text;
}
