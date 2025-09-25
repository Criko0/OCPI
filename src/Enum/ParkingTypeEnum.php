<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1418-parkingtype-enum.
 */
enum ParkingTypeEnum: string
{
    case ALONG_MOTORWAY = 'ALONG_MOTORWAY'; // Location on a parking facility/rest area along a motorway, freeway, interstate, highway etc.
    case PARKING_GARAGE = 'PARKING_GARAGE'; // Multistorey car park.
    case PARKING_LOT = 'PARKING_LOT'; // A cleared area that is intended for parking vehicles, i.e. at super markets, bars, etc.
    case ON_DRIVEWAY = 'ON_DRIVEWAY'; // Location is on the driveway of a house/building.
    case ON_STREET = 'ON_STREET'; // Parking in public space along a street.
    case UNDERGROUND_GARAGE = 'UNDERGROUND_GARAGE'; // Multistorey car park, mainly underground.
}
