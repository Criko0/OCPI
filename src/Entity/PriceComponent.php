<?php

namespace App\Entity;

use App\Enum\TariffDimensionTypeEnum;
use App\Repository\PriceComponentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_tariffs.asciidoc#142-pricecomponent-class.
 */
#[ORM\Entity(repositoryClass: PriceComponentRepository::class)]
class PriceComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: TariffDimensionTypeEnum::class, options: ['comment' => 'The dimension that is being priced'])]
    private TariffDimensionTypeEnum $type;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, options: ['comment' => 'Price per unit (excl. VAT) for this dimension.'])]
    private string $price;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true, options: ['comment' => 'Applicable VAT percentage for this tariff dimension. If omitted, no VAT is applicable. Not providing a VAT is different from 0% VAT, which would be a value of 0.0 here.'])]
    private ?string $vat = null;

    #[ORM\Column(options: ['comment' => 'Minimum amount to be billed. That is, the dimension will be billed in this step_size blocks. Consumed amounts are rounded up to the smallest multiple of step_size that is greater than the consumed amount. For example: if type is TIME and step_size has a value of 300, then time will be billed in blocks of 5 minutes. If 6 minutes were consumed, 10 minutes (2 blocks of step_size) will be billed.'])]
    private int $stepSize;

    public function __construct(
        TariffDimensionTypeEnum $type,
        string $price,
        int $stepSize,
    ) {
        $this->type = $type;
        $this->price = $price;
        $this->stepSize = $stepSize;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): TariffDimensionTypeEnum
    {
        return $this->type;
    }

    public function setType(TariffDimensionTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(?string $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function getStepSize(): int
    {
        return $this->stepSize;
    }

    public function setStepSize(int $stepSize): static
    {
        $this->stepSize = $stepSize;

        return $this;
    }
}
