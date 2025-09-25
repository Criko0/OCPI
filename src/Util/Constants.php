<?php

namespace App\Util;

final class Constants
{
    public const PARTY_IDENTIFIER_PATH = '/{countryCode<[A-Z]{2}>}/{partyId<[A-Z0-9]{3}>}';

    public const AUTHORIZATION_TOKEN_LITERAL = 'Token ';
}
