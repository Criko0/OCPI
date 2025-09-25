<?php

namespace App\Dto\V221\tariffs;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;

class EnergyMixDto
{
    #[Map(target: 'isGreenEnergy', source: 'is_green_energy')]
    #[SerializedName('is_green_energy')]
    public bool $isGreenEnergy;

    /**
     * @var array<array-key, EnergySourceDto>|null
     */
    #[Map(target: 'energySources', source: 'energy_sources')]
    #[SerializedName('energy_sources')]
    public ?array $energySources;

    /**
     * @var array<array-key, EnvironmentalImpactDto>|null
     */
    #[Map(target: 'environImpact', source: 'environ_impact')]
    #[SerializedName('environ_impact')]
    public ?array $environImpact = null;

    #[Map(target: 'supplierName', source: 'supplier_name')]
    #[SerializedName('supplier_name')]
    public ?string $supplierName;

    #[Map(target: 'energyProductName', source: 'energy_product_name')]
    #[SerializedName('energy_product_name')]
    public ?string $energyProductName;
}
