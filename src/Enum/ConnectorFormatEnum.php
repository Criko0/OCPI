<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#144-connectorformat-enum.
 */
enum ConnectorFormatEnum: string
{
    case SOCKET = 'SOCKET'; // The connector is a socket; the EV user needs to bring a fitting plug.
    case CABLE = 'CABLE'; // The connector is an attached cable; the EV users car needs to have a fitting inlet.
}
