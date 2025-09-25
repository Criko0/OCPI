<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_tariffs.asciidoc#143-reservationrestrictiontype-enum.
 */
enum ReservationRestrictionTypeEnum: string
{
    case RESERVATION = 'RESERVATION'; // Used in Tariff Elements to describe costs for a reservation.
    case RESERVATION_EXPIRES = 'RESERVATION_EXPIRES'; // Used in Tariff Elements to describe costs for a reservation that expires (i.e. driver does not start a charging session before expiry_date of the reservation).
}
