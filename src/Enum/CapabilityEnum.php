<?php

namespace App\Enum;

/**
 * Reference: https://github.com/ocpi/ocpi/blob/release-2.2.1-bugfixes/mod_locations.asciidoc#143-capability-enum.
 */
enum CapabilityEnum: string
{
    case CHARGING_PROFILE_CAPABLE = 'CHARGING_PROFILE_CAPABLE'; // The EVSE supports charging profiles.
    case CHARGING_PREFERENCES_CAPABLE = 'CHARGING_PREFERENCES_CAPABLE'; // The EVSE supports charging preferences.
    case CHIP_CARD_SUPPORT = 'CHIP_CARD_SUPPORT'; // EVSE has a payment terminal that supports chip cards.
    case CONTACTLESS_CARD_SUPPORT = 'CONTACTLESS_CARD_SUPPORT'; // EVSE has a payment terminal that supports contactless cards.
    case CREDIT_CARD_PAYABLE = 'CREDIT_CARD_PAYABLE'; // EVSE has a payment terminal that makes it possible to pay for charging using a credit card.
    case DEBIT_CARD_PAYABLE = 'DEBIT_CARD_PAYABLE'; // EVSE has a payment terminal that makes it possible to pay for charging using a debit card.
    case PED_TERMINAL = 'PED_TERMINAL'; // EVSE has a payment terminal with a pin-code entry device.
    case REMOTE_START_STOP_CAPABLE = 'REMOTE_START_STOP_CAPABLE'; // The EVSE can remotely be started/stopped.
    case RESERVABLE = 'RESERVABLE'; // The EVSE can be reserved.
    case RFID_READER = 'RFID_READER'; // Charging at this EVSE can be authorized with an RFID token.
    case START_SESSION_CONNECTOR_REQUIRED = 'START_SESSION_CONNECTOR_REQUIRED'; // When a StartSession is sent to this EVSE, the MSP is required to add the optional connector_id field in the StartSession object.
    case TOKEN_GROUP_CAPABLE = 'TOKEN_GROUP_CAPABLE'; // This EVSE supports token groups, two or more tokens work as one, so that a session can be started with one token and stopped with another (handy when a card and key-fob are given to the EV-driver).
    case UNLOCK_CAPABLE = 'UNLOCK_CAPABLE'; // Connectors have mechanical lock that can be requested by the eMSP to be unlocked.
}
