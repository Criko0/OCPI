<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/version_information_endpoint.asciidoc#version_information_endpoint_versionnumber_enum.
 */
enum VersionNumberEnum: string
{
    case V2_0 = '2.0'; // OCPI version 2.0
    case V2_1 = '2.1'; // OCPI version 2.1 (DEPRECATED, do not use, use 2.1.1 instead)
    case V2_1_1 = '2.1.1'; // OCPI version 2.1.1
    case V2_2 = '2.2'; // OCPI version 2.2 (DEPRECATED, do not use, use 2.2.1 instead)
    case V2_2_1 = '2.2.1'; // OCPI version 2.2.1 (this version)
}
