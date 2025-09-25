<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/status_codes.asciidoc.
 */
enum StatusCodesEnum: int
{
    case STATUS_1000 = 1000; // Generic success code

    case STATUS_2000 = 2000; // Generic client error
    case STATUS_2001 = 2001; // Invalid or missing parameters , for example: missing last_updated field in a PATCH request.
    case STATUS_2002 = 2002; // Not enough information, for example: Authorization request with too little information.
    case STATUS_2003 = 2003; // Unknown Location, for example: Command: START_SESSION with unknown location.
    case STATUS_2004 = 2004; // Unknown Token, for example: 'real-time' authorization of an unknown Token.

    case STATUS_3000 = 3000; //  Generic server error
    case STATUS_3001 = 3001; //  Unable to use the client’s API. For example during the credentials registration: When the initializing party requests data from the other party during the open POST call to its credentials endpoint. If one of the GETs can not be processed, the party should return this error in the POST response.
    case STATUS_3002 = 3002; //  Unsupported version
    case STATUS_3003 = 3003; //  No matching endpoints or expected endpoints missing between parties. Used during the registration process if the two parties do not have any mutual modules or endpoints available, or the minimal implementation expected by the other party is not been met.

    case STATUS_4000 = 4000; // Generic error
    case STATUS_4001 = 4001; // Unknown receiver (TO address is unknown)
    case STATUS_4002 = 4002; // Timeout on forwarded request (message is forwarded, but request times out)
    case STATUS_4003 = 4003; // Connection problem (receiving party is not connected)

    public function message(): string
    {
        return match ($this) {
            StatusCodesEnum::STATUS_1000 => 'Generic success code',
            StatusCodesEnum::STATUS_2000 => 'Generic client error',
            StatusCodesEnum::STATUS_2001 => 'Invalid or missing parameters',
            StatusCodesEnum::STATUS_2002 => 'Not enough information',
            StatusCodesEnum::STATUS_2003 => 'Unknown Location',
            StatusCodesEnum::STATUS_2004 => 'Unknown Token',
            StatusCodesEnum::STATUS_3000 => 'Generic server error',
            StatusCodesEnum::STATUS_3001 => 'Unable to use the client`s API',
            StatusCodesEnum::STATUS_3002 => 'Unsupported version',
            StatusCodesEnum::STATUS_3003 => 'No matching endpoints or expected endpoints missing between parties',
            StatusCodesEnum::STATUS_4000 => 'Generic error',
            StatusCodesEnum::STATUS_4001 => 'Unknown receiver',
            StatusCodesEnum::STATUS_4002 => 'Timeout on forwarded request',
            StatusCodesEnum::STATUS_4003 => 'Connection problem ',
        };
    }
}
