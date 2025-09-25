<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Price
{
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private string $exclVat;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $inclVat = null;

    public function __construct(
        string $exclVat,
    ) {
        $this->exclVat = $exclVat;
    }

    public function getExclVat(): string
    {
        return $this->exclVat;
    }

    public function setExclVat(string $exclVat): static
    {
        $this->exclVat = $exclVat;

        return $this;
    }

    public function getInclVat(): ?string
    {
        return $this->inclVat;
    }

    public function setInclVat(string $inclVat): static
    {
        $this->inclVat = $inclVat;

        return $this;
    }
}
