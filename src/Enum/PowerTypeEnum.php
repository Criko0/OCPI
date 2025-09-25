<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1419-powertype-enum.
 */
enum PowerTypeEnum: string
{
    case AC_1_PHASE = 'AC_1_PHASE'; // AC single phase.
    case AC_2_PHASE = 'AC_2_PHASE'; // AC two phases, only two of the three available phases connected.
    case AC_2_PHASE_SPLIT = 'AC_2_PHASE_SPLIT'; // AC two phases using split phase system.
    case AC_3_PHASE = 'AC_3_PHASE'; // AC three phases.
    case DC = 'DC'; // Direct Current.
}
