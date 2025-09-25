<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_tariffs.asciidoc#147-tarifftype-enum.
 */
enum TariffDimensionTypeEnum: string
{
    case ENERGY = 'ENERGY'; // Defined in kWh, step_size multiplier: 1 Wh
    case FLAT = 'FLAT'; // Flat fee without unit for step_size
    case PARKING_TIME = 'PARKING_TIME'; // Time not charging: defined in hours, step_size multiplier: 1 second
    case TIME = 'TIME'; // Time charging: defined in hours, step_size multiplier: 1 second Can also be used in combination with a RESERVATION restriction to describe the price of the reservation time.
}
