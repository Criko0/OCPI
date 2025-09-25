<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#148-energysourcecategory-enum.
 */
enum EnergySourceCategoryEnum: string
{
    case NUCLEAR = 'NUCLEAR'; // Nuclear power sources.
    case GENERAL_FOSSIL = 'GENERAL_FOSSIL'; // All kinds of fossil power sources.
    case COAL = 'COAL'; // Fossil power from coal.
    case GAS = 'GAS'; // Fossil power from gas.
    case GENERAL_GREEN = 'GENERAL_GREEN'; // All kinds of regenerative power sources.
    case SOLAR = 'SOLAR'; // Regenerative power from PV.
    case WIND = 'WIND'; // Regenerative power from wind turbines.
    case WATER = 'WATER'; // Regenerative power from water turbines.
}
