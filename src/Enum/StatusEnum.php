<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1422-status-enum.
 */
enum StatusEnum: string
{
    case AVAILABLE = 'AVAILABLE'; // The EVSE/Connector is able to start a new charging session.
    case BLOCKED = 'BLOCKED'; // The EVSE/Connector is not accessible because of a physical barrier, i.e. a car.
    case CHARGING = 'CHARGING'; // The EVSE/Connector is in use.
    case INOPERATIVE = 'INOPERATIVE'; // The EVSE/Connector is not yet active, or temporarily not available for use, but not broken or defect.
    case OUTOFORDER = 'OUTOFORDER'; // The EVSE/Connector is currently out of order, some part/components may be broken/defect.
    case PLANNED = 'PLANNED'; // The EVSE/Connector is planned, will be operating soon.
    case REMOVED = 'REMOVED'; // The EVSE/Connector was discontinued/removed.
    case RESERVED = 'RESERVED'; // The EVSE/Connector is reserved for a particular EV driver and is unavailable for other drivers.
    case UNKNOWN = 'UNKNOWN'; // No status information available (also used when offline).
}
