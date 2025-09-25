<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1417-parkingrestriction-enum.
 */
enum ParkingRestrictionEnum: string
{
    case EV_ONLY = 'EV_ONLY'; // Reserved parking spot for electric vehicles.
    case PLUGGED = 'PLUGGED'; // Parking is only allowed while plugged in (charging).
    case DISABLED = 'DISABLED'; // Reserved parking spot for disabled people with valid ID.
    case CUSTOMERS = 'CUSTOMERS'; // Parking spot for customers/guests only, for example in case of a hotel or shop.
    case MOTORCYCLES = 'MOTORCYCLES'; // Parking spot only suitable for (electric) motorcycles or scooters.
}
