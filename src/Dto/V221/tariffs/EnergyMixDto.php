<?php

namespace App\Dto\V221\tariffs;

use Symfony\Component\Serializer\Attribute\SerializedName;

class EnergyMixDto
{
    #[SerializedName('is_green_energy')]
    public bool $isGreenEnergy;

    /**
     * @var array<array-key, EnergySourceDto>|null
     */
    #[SerializedName('energy_sources')]
    public ?array $energySources;

    /**
     * @var array<array-key, EnvironmentalImpactDto>|null
     */
    #[SerializedName('environ_impact')]
    public ?array $environImpact = null;

    #[SerializedName('supplier_name')]
    public ?string $supplierName;

    #[SerializedName('energy_product_name')]
    public ?string $energyProductName;
}
