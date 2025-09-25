<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1412-facility-enum.
 */
enum FacilityEnum: string
{
    case HOTEL = 'HOTEL'; // A hotel.
    case RESTAURANT = 'RESTAURANT'; // A restaurant.
    case CAFE = 'CAFE'; // A cafe.
    case MALL = 'MALL'; // A mall or shopping center.
    case SUPERMARKET = 'SUPERMARKET'; // A supermarket.
    case SPORT = 'SPORT'; // Sport facilities: gym, field etc.
    case RECREATION_AREA = 'RECREATION_AREA'; // A recreation area.
    case NATURE = 'NATURE'; // Located in, or close to, a park, nature reserve etc.
    case MUSEUM = 'MUSEUM'; // A museum.
    case BIKE_SHARING = 'BIKE_SHARING'; // A bike/e-bike/e-scooter sharing location.
    case BUS_STOP = 'BUS_STOP'; // A bus stop.
    case TAXI_STAND = 'TAXI_STAND'; // A taxi stand.
    case TRAM_STOP = 'TRAM_STOP'; // A tram stop/station.
    case METRO_STATION = 'METRO_STATION'; // A metro station.
    case TRAIN_STATION = 'TRAIN_STATION'; // A train station.
    case AIRPORT = 'AIRPORT'; // An airport.
    case PARKING_LOT = 'PARKING_LOT'; // A parking lot.
    case CARPOOL_PARKING = 'CARPOOL_PARKING'; // A carpool parking.
    case FUEL_STATION = 'FUEL_STATION'; // A Fuel station.
    case WIFI = 'WIFI'; // Wifi or other type of internet available.
}
