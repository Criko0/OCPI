<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#1416-imagecategory-enum.
 */
enum ImageCategoryEnum: string
{
    case CHARGER = 'CHARGER'; // Photo of the physical device that contains one or more EVSEs.
    case ENTRANCE = 'ENTRANCE'; // Location entrance photo. Should show the car entrance to the location from street side.
    case LOCATION = 'LOCATION'; // Location overview photo.
    case NETWORK = 'NETWORK'; // Logo of an associated roaming network to be displayed with the EVSE for example in lists, maps and detailed information views.
    case OPERATOR = 'OPERATOR'; // Logo of the charge point operator, for example a municipality, to be displayed in the EVSEs detailed information view or in lists and maps, if no network logo is present.
    case OTHER = 'OTHER'; // Other
    case OWNER = 'OWNER'; // Logo of the charge point owner, for example a local store, to be displayed in the EVSEs detailed information view.
}
