<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/types.asciidoc#types_role_enum.
 */
enum RoleEnum: string
{
    case CPO = 'CPO'; // Charge Point Operator Role.
    case EMSP = 'EMSP'; // eMobility Service Provider Role.
    case HUB = 'HUB'; // Hub role.
    case NAP = 'NAP'; // National Access Point Role (national Database with all Location information of a country).
    case NSP = 'NSP'; // Navigation Service Provider Role, role like an eMSP (probably only interested in Location information).
    case OTHER = 'OTHER'; // Other role.
    case SCSP = 'SCSP'; // Smart Charging Service Provider Role.
}
