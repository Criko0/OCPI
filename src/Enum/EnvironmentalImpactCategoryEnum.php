<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1410-environmentalimpactcategory-enum.
 */
enum EnvironmentalImpactCategoryEnum: string
{
    case NUCLEAR_WASTE = 'NUCLEAR_WASTE'; // Produced nuclear waste in grams per kilowatthour.
    case CARBON_DIOXIDE = 'CARBON_DIOXIDE'; // Exhausted carbon dioxide in grams per kilowatthour.
}
