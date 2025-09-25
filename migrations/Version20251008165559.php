<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251008165559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_geo_location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name_id INTEGER DEFAULT NULL, location_id INTEGER NOT NULL, latitude VARCHAR(10) NOT NULL --Latitude of the point in decimal degree. Example: 50.770774. Decimal separator: "." Regex: -?[0-9]{1,2}\\.[0-9]{5,7}
        , longitude VARCHAR(11) NOT NULL --Longitude of the point in decimal degree. Example: -126.104965. Decimal separator: "." Regex: -?[0-9]{1,3}\\.[0-9]{5,7}
        , CONSTRAINT FK_CCCBB19771179CD6 FOREIGN KEY (name_id) REFERENCES display_text (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CCCBB19764D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CCCBB19771179CD6 ON additional_geo_location (name_id)');
        $this->addSql('CREATE INDEX IDX_CCCBB19764D218E ON additional_geo_location (location_id)');
        $this->addSql('CREATE TABLE business_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, logo_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL, website VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_2F15B0C7F98F144A FOREIGN KEY (logo_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F15B0C7F98F144A ON business_details (logo_id)');
        $this->addSql('CREATE TABLE connector (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, evse_id INTEGER NOT NULL, connector_id VARCHAR(36) NOT NULL --Identifier of the Connector within the EVSE. Two Connectors may have the same id as long as they do not belong to the same EVSE object.
        , standard VARCHAR(255) NOT NULL --The standard of the installed connector.
        , format VARCHAR(255) NOT NULL --The format (socket/cable) of the installed connector.
        , power_type VARCHAR(255) NOT NULL, max_voltage INTEGER NOT NULL --Maximum voltage of the connector (line to neutral for AC_3_PHASE), in volt [V]. For example: DC Chargers might vary the voltage during charging when battery almost full.
        , max_amperage INTEGER NOT NULL --Maximum amperage of the connector, in ampere [A].
        , max_electric_power INTEGER DEFAULT NULL --Maximum electric power that can be delivered by this connector, in Watts (W). When the maximum electric power is lower than the calculated value from voltage and amperage, this value should be set. For example: A DC Charge Point which can delivers up to 920V and up to 400A can be limited to a maximum of 150kW (max_electric_power = 150000). Depending on the car, it may supply max voltage or current, but not both at the same time. For AC Charge Points, the amount of phases used can also have influence on the maximum power.
        , terms_and_conditions VARCHAR(255) DEFAULT NULL --URL to the operator’s terms and conditions.
        , last_updated DATETIME NOT NULL --Timestamp when this Connector was last updated (or created).(DC2Type:datetime_immutable)
        , CONSTRAINT FK_148C456EB213D3EC FOREIGN KEY (evse_id) REFERENCES evse (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_148C456EB213D3EC ON connector (evse_id)');
        $this->addSql('CREATE TABLE connector_tariff (connector_id INTEGER NOT NULL, tariff_id INTEGER NOT NULL, PRIMARY KEY(connector_id, tariff_id), CONSTRAINT FK_4227F6C24D085745 FOREIGN KEY (connector_id) REFERENCES connector (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4227F6C292348FD2 FOREIGN KEY (tariff_id) REFERENCES tariff (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4227F6C24D085745 ON connector_tariff (connector_id)');
        $this->addSql('CREATE INDEX IDX_4227F6C292348FD2 ON connector_tariff (tariff_id)');
        $this->addSql('CREATE TABLE credentials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, token VARCHAR(64) NOT NULL, url VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE credentials_role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, business_details_id INTEGER NOT NULL, credentials_id INTEGER NOT NULL, role VARCHAR(255) NOT NULL, party_id VARCHAR(3) NOT NULL --CPO, eMSP (or other role) ID of this party (following the ISO-15118 standard).
        , country_code VARCHAR(2) NOT NULL --ISO-3166 alpha-2 country code of the country this party is operating in.
        , CONSTRAINT FK_3862081D7BB90F89 FOREIGN KEY (business_details_id) REFERENCES business_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3862081D41E8B2E5 FOREIGN KEY (credentials_id) REFERENCES credentials (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3862081D7BB90F89 ON credentials_role (business_details_id)');
        $this->addSql('CREATE INDEX IDX_3862081D41E8B2E5 ON credentials_role (credentials_id)');
        $this->addSql('CREATE TABLE display_text (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, language VARCHAR(2) NOT NULL --Language Code ISO 639-1.
        , text VARCHAR(512) NOT NULL --Text to be displayed to a end user. No markup, html etc. allowed.
        )');
        $this->addSql('CREATE TABLE energy_mix (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, is_green_energy BOOLEAN NOT NULL --True if 100% from regenerative sources. (CO2 and nuclear waste is zero)
        , supplier_name VARCHAR(64) DEFAULT NULL --Name of the energy supplier, delivering the energy for this location or tariff.*
        , energy_product_name VARCHAR(64) DEFAULT NULL --Name of the energy suppliers product/tariff plan used at this location.*
        )');
        $this->addSql('CREATE TABLE energy_source (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, energy_mix_id INTEGER NOT NULL, source VARCHAR(255) NOT NULL --The type of energy source.
        , percentage NUMERIC(10, 4) NOT NULL --Percentage of this source (0-100) in the mix.
        , CONSTRAINT FK_BE3CDE5E47B79D67 FOREIGN KEY (energy_mix_id) REFERENCES energy_mix (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BE3CDE5E47B79D67 ON energy_source (energy_mix_id)');
        $this->addSql('CREATE TABLE environmental_impact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, energy_mix_id INTEGER NOT NULL, category VARCHAR(255) NOT NULL --The environmental impact category of this value.
        , amount NUMERIC(10, 4) NOT NULL --Amount of this portion in g/kWh.
        , CONSTRAINT FK_40FFE79B47B79D67 FOREIGN KEY (energy_mix_id) REFERENCES energy_mix (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_40FFE79B47B79D67 ON environmental_impact (energy_mix_id)');
        $this->addSql('CREATE TABLE evse (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id INTEGER NOT NULL, uid VARCHAR(36) NOT NULL --Uniquely identifies the EVSE within the CPOs platform (and suboperator platforms). This field can never be changed, modified or renamed. This is the `technical` identification of the EVSE, not to be used as `human readable` identification, use the field evse_id for that. This field is named uid instead of id, because id could be confused with evse_id which is an eMI3 defined field. Note that in order to fulfill both the requirement that an EVSE’s uid be unique within a CPO’s platform and the requirement that EVSEs are never deleted, a CPO will typically want to avoid using identifiers of the physical hardware for this uid property. If they do use such a physical identifier, they will find themselves breaking the uniqueness requirement for uid when the same physical EVSE is redeployed at another Location.
        , evse_id VARCHAR(48) DEFAULT NULL --Compliant with the following specification for EVSE ID from "eMI3 standard version V1.0" (https://web.archive.org/web/20230603153631/https://emi3group.com/documents-links/) "Part 2: business objects." Optional because: if an evse_id is to be re-used in the real world, the evse_id can be removed from an EVSE object if the status is set to REMOVED.
        , status VARCHAR(255) NOT NULL --Indicates the current status of the EVSE.
        , capabilities CLOB DEFAULT NULL --List of functionalities that the EVSE is capable of.(DC2Type:simple_array)
        , floor_level VARCHAR(4) DEFAULT NULL --Level on which the Charge Point is located (in garage buildings) in the locally displayed numbering scheme.
        , physical_reference VARCHAR(16) DEFAULT NULL --A number/string printed on the outside of the EVSE for visual identification.
        , parking_restrictions CLOB DEFAULT NULL --The restrictions that apply to the parking spot.(DC2Type:simple_array)
        , last_updated DATETIME NOT NULL --Timestamp when this EVSE or one of its Connectors was last updated (or created).(DC2Type:datetime_immutable)
        , latitude VARCHAR(10) NOT NULL --Latitude of the point in decimal degree. Example: 50.770774. Decimal separator: "." Regex: -?[0-9]{1,2}\\.[0-9]{5,7}
        , longitude VARCHAR(10) NOT NULL --Longitude of the point in decimal degree. Example: -126.104965. Decimal separator: "." Regex: -?[0-9]{1,3}\\.[0-9]{5,7}
        , CONSTRAINT FK_440A732D64D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_440A732D64D218E ON evse (location_id)');
        $this->addSql('CREATE TABLE evse_display_text (evse_id INTEGER NOT NULL, display_text_id INTEGER NOT NULL, PRIMARY KEY(evse_id, display_text_id), CONSTRAINT FK_38C2AFFEB213D3EC FOREIGN KEY (evse_id) REFERENCES evse (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_38C2AFFE5E62D7D3 FOREIGN KEY (display_text_id) REFERENCES display_text (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_38C2AFFEB213D3EC ON evse_display_text (evse_id)');
        $this->addSql('CREATE INDEX IDX_38C2AFFE5E62D7D3 ON evse_display_text (display_text_id)');
        $this->addSql('CREATE TABLE evse_image (evse_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(evse_id, image_id), CONSTRAINT FK_526BA14CB213D3EC FOREIGN KEY (evse_id) REFERENCES evse (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_526BA14C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_526BA14CB213D3EC ON evse_image (evse_id)');
        $this->addSql('CREATE INDEX IDX_526BA14C3DA5256D ON evse_image (image_id)');
        $this->addSql('CREATE TABLE exceptional_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hours_id INTEGER NOT NULL, period_begin DATETIME NOT NULL --Begin of the exception. In UTC, time_zone field can be used to convert to local time.(DC2Type:datetime_immutable)
        , period_end DATETIME NOT NULL --End of the exception. In UTC, time_zone field can be used to convert to local time.(DC2Type:datetime_immutable)
        , CONSTRAINT FK_C3DE86D923A564E6 FOREIGN KEY (hours_id) REFERENCES hours (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C3DE86D923A564E6 ON exceptional_period (hours_id)');
        $this->addSql('CREATE TABLE hours (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, twentyfourseven BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL --URL from where the image data can be fetched through a web browser.
        , thumbnail VARCHAR(255) DEFAULT NULL --URL from where a thumbnail of the image can be fetched through a webbrowser.
        , category VARCHAR(255) NOT NULL --Describes what the image is used for.
        , type VARCHAR(4) NOT NULL --Image type like: gif, jpeg, png, svg.
        , width INTEGER DEFAULT NULL --Width of the full scale image.
        , height INTEGER DEFAULT NULL --Height of the full scale image.
        , CONSTRAINT FK_C53D045F64D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C53D045F64D218E ON image (location_id)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, operator_id INTEGER NOT NULL, suboperator_id INTEGER DEFAULT NULL, owner_id INTEGER DEFAULT NULL, opening_times_id INTEGER DEFAULT NULL, energy_mix_id INTEGER DEFAULT NULL, country_code VARCHAR(2) NOT NULL, party_id VARCHAR(3) NOT NULL, location_id VARCHAR(36) NOT NULL, publish BOOLEAN NOT NULL, name VARCHAR(255) DEFAULT NULL, addres VARCHAR(45) NOT NULL, city VARCHAR(45) NOT NULL, postal_code VARCHAR(10) DEFAULT NULL, state VARCHAR(20) DEFAULT NULL, country VARCHAR(3) NOT NULL, parking_type VARCHAR(255) DEFAULT NULL, facilities CLOB DEFAULT NULL --(DC2Type:simple_array)
        , time_zone VARCHAR(255) NOT NULL, charging_when_closed BOOLEAN DEFAULT NULL, last_updated DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , latitude VARCHAR(10) NOT NULL --Latitude of the point in decimal degree. Example: 50.770774. Decimal separator: "." Regex: -?[0-9]{1,2}\\.[0-9]{5,7}
        , longitude VARCHAR(10) NOT NULL --Longitude of the point in decimal degree. Example: -126.104965. Decimal separator: "." Regex: -?[0-9]{1,3}\\.[0-9]{5,7}
        , CONSTRAINT FK_5E9E89CB584598A3 FOREIGN KEY (operator_id) REFERENCES business_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E9E89CB17C5FB16 FOREIGN KEY (suboperator_id) REFERENCES business_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E9E89CB7E3C61F9 FOREIGN KEY (owner_id) REFERENCES business_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E9E89CBBBA85752 FOREIGN KEY (opening_times_id) REFERENCES hours (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E9E89CB47B79D67 FOREIGN KEY (energy_mix_id) REFERENCES energy_mix (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB584598A3 ON location (operator_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB17C5FB16 ON location (suboperator_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB7E3C61F9 ON location (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CBBBA85752 ON location (opening_times_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB47B79D67 ON location (energy_mix_id)');
        $this->addSql('CREATE TABLE location_display_text (location_id INTEGER NOT NULL, display_text_id INTEGER NOT NULL, PRIMARY KEY(location_id, display_text_id), CONSTRAINT FK_C1461AE864D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C1461AE85E62D7D3 FOREIGN KEY (display_text_id) REFERENCES display_text (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C1461AE864D218E ON location_display_text (location_id)');
        $this->addSql('CREATE INDEX IDX_C1461AE85E62D7D3 ON location_display_text (display_text_id)');
        $this->addSql('CREATE TABLE price_component (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL --The dimension that is being priced
        , price NUMERIC(10, 4) NOT NULL --Price per unit (excl. VAT) for this dimension.
        , vat NUMERIC(10, 4) DEFAULT NULL --Applicable VAT percentage for this tariff dimension. If omitted, no VAT is applicable. Not providing a VAT is different from 0% VAT, which would be a value of 0.0 here.
        , step_size INTEGER NOT NULL --Minimum amount to be billed. That is, the dimension will be billed in this step_size blocks. Consumed amounts are rounded up to the smallest multiple of step_size that is greater than the consumed amount. For example: if type is TIME and step_size has a value of 300, then time will be billed in blocks of 5 minutes. If 6 minutes were consumed, 10 minutes (2 blocks of step_size) will be billed.
        )');
        $this->addSql('CREATE TABLE publish_token_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id INTEGER NOT NULL, uid VARCHAR(36) DEFAULT NULL --Unique ID by which this Token can be identified.
        , type VARCHAR(255) DEFAULT NULL --Type of the token.
        , visual_number VARCHAR(64) DEFAULT NULL --Visual readable number/identification as printed on the Token (RFID card).
        , issuer VARCHAR(64) DEFAULT NULL --Issuing company, most of the times the name of the company printed on the token (RFID card), not necessarily the eMSP.
        , group_id VARCHAR(36) DEFAULT NULL --This ID groups a couple of tokens. This can be used to make two or more tokens work as one.
        , CONSTRAINT FK_6ABE641364D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6ABE641364D218E ON publish_token_type (location_id)');
        $this->addSql('CREATE TABLE regular_hours (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hours_id INTEGER NOT NULL, weekday INTEGER NOT NULL --Number of day in the week, from Monday (1) till Sunday (7)
        , period_begin VARCHAR(5) NOT NULL --Begin of the regular period, in local time, given in hours and minutes. Must be in 24h format with leading zeros. Example: "18:15". Hour/Minute separator: ":" Regex: ([0-1][0-9]|2[0-3]):[0-5][0-9].
        , period_end VARCHAR(5) NOT NULL --End of the regular period, in local time, syntax as for period_begin. Must be later than period_begin.
        , CONSTRAINT FK_60A3BA1723A564E6 FOREIGN KEY (hours_id) REFERENCES hours (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_60A3BA1723A564E6 ON regular_hours (hours_id)');
        $this->addSql('CREATE TABLE status_schedule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, evse_id INTEGER NOT NULL, period_begin DATETIME NOT NULL --Begin of the scheduled period.(DC2Type:datetime_immutable)
        , period_end DATETIME DEFAULT NULL --End of the scheduled period, if known.(DC2Type:datetime_immutable)
        , status VARCHAR(255) NOT NULL --Status value during the scheduled period.
        , CONSTRAINT FK_C7E2B623B213D3EC FOREIGN KEY (evse_id) REFERENCES evse (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C7E2B623B213D3EC ON status_schedule (evse_id)');
        $this->addSql('CREATE TABLE tariff (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, energy_mix_id INTEGER DEFAULT NULL, country_code VARCHAR(2) NOT NULL --ISO-3166 alpha-2 country code of the CPO that owns this Tariff.
        , party_id VARCHAR(3) NOT NULL --ID of the CPO that `owns` this Tariff (following the ISO-15118 standard).
        , tariff_id VARCHAR(36) NOT NULL --Uniquely identifies the tariff within the CPO’s platform (and suboperator platforms).
        , currency VARCHAR(3) NOT NULL --ISO-4217 code of the currency of this tariff.
        , type VARCHAR(255) DEFAULT NULL --Defines the type of the tariff. This allows for distinction in case of given Charging Preferences. When omitted, this tariff is valid for all sessions.
        , tariff_alt_url VARCHAR(255) DEFAULT NULL --URL to a web page that contains an explanation of the tariff information in human readable form.
        , start_date_time DATETIME DEFAULT NULL --The time when this tariff becomes active, in UTC, time_zone field of the Location can be used to convert to local time. Typically used for a new tariff that is already given with the location, before it becomes active.(DC2Type:datetime_immutable)
        , end_date_time DATETIME DEFAULT NULL --The time after which this tariff is no longer valid, in UTC, time_zone field if the Location can be used to convert to local time. Typically used when this tariff is going to be replaced with a different tariff in the near future.(DC2Type:datetime_immutable)
        , last_updated DATETIME NOT NULL --Timestamp when this Tariff was last updated (or created).(DC2Type:datetime_immutable)
        , min_priceexcl_vat NUMERIC(10, 4) NOT NULL, min_priceincl_vat NUMERIC(10, 4) NOT NULL, max_priceexcl_vat NUMERIC(10, 4) NOT NULL, max_priceincl_vat NUMERIC(10, 4) NOT NULL, CONSTRAINT FK_9465207D47B79D67 FOREIGN KEY (energy_mix_id) REFERENCES energy_mix (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9465207D47B79D67 ON tariff (energy_mix_id)');
        $this->addSql('CREATE TABLE tariff_display_text (tariff_id INTEGER NOT NULL, display_text_id INTEGER NOT NULL, PRIMARY KEY(tariff_id, display_text_id), CONSTRAINT FK_E690FDC492348FD2 FOREIGN KEY (tariff_id) REFERENCES tariff (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E690FDC45E62D7D3 FOREIGN KEY (display_text_id) REFERENCES display_text (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E690FDC492348FD2 ON tariff_display_text (tariff_id)');
        $this->addSql('CREATE INDEX IDX_E690FDC45E62D7D3 ON tariff_display_text (display_text_id)');
        $this->addSql('CREATE TABLE tariff_element (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tariff_id INTEGER NOT NULL, CONSTRAINT FK_B15F1DA092348FD2 FOREIGN KEY (tariff_id) REFERENCES tariff (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B15F1DA092348FD2 ON tariff_element (tariff_id)');
        $this->addSql('CREATE TABLE tariff_element_price_component (tariff_element_id INTEGER NOT NULL, price_component_id INTEGER NOT NULL, PRIMARY KEY(tariff_element_id, price_component_id), CONSTRAINT FK_4F20605BBB81B898 FOREIGN KEY (tariff_element_id) REFERENCES tariff_element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4F20605B1678C3E2 FOREIGN KEY (price_component_id) REFERENCES price_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4F20605BBB81B898 ON tariff_element_price_component (tariff_element_id)');
        $this->addSql('CREATE INDEX IDX_4F20605B1678C3E2 ON tariff_element_price_component (price_component_id)');
        $this->addSql('CREATE TABLE tariff_restrictions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tariff_element_id INTEGER DEFAULT NULL, start_time VARCHAR(5) DEFAULT NULL --Start time of day in local time, the time zone is defined in the time_zone field of the Location, for example 13:30, valid from this time of the day. Must be in 24h format with leading zeros. Hour/Minute separator: ":" Regex: ([0-1][0-9]|2[0-3]):[0-5][0-9]
        , end_time VARCHAR(5) DEFAULT NULL --End time of day in local time, the time zone is defined in the time_zone field of the Location, for example 19:45, valid until this time of the day. Same syntax as start_time. If end_time < start_time then the period wraps around to the next day. To stop at end of the day use: 00:00.
        , start_date DATE DEFAULT NULL --Start date in local time, the time zone is defined in the time_zone field of the Location, for example: 2015-12-24, valid from this day (inclusive). Regex: ([12][0-9]{3})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])(DC2Type:date_immutable)
        , end_date DATE DEFAULT NULL --End date in local time, the time zone is defined in the time_zone field of the Location, for example: 2015-12-27, valid until this day (exclusive). Same syntax as start_date.(DC2Type:date_immutable)
        , min_kwh NUMERIC(10, 4) DEFAULT NULL --Minimum consumed energy in kWh, for example 20, valid from this amount of energy (inclusive) being used.
        , max_kwh NUMERIC(10, 4) DEFAULT NULL --Maximum consumed energy in kWh, for example 50, valid until this amount of energy (exclusive) being used.
        , min_current NUMERIC(10, 4) DEFAULT NULL --Sum of the minimum current (in Amperes) over all phases, for example 5. When the EV is charging with more than, or equal to, the defined amount of current, this TariffElement is/becomes active. If the charging current is or becomes lower, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the minimum current over the entire Charging Session. This restriction can make a TariffElement become active when the charging current is above the defined value, but the TariffElement MUST no longer be active when the charging current drops below the defined value.
        , max_current NUMERIC(10, 4) DEFAULT NULL --Sum of the maximum current (in Amperes) over all phases, for example 20. When the EV is charging with less than the defined amount of current, this TariffElement becomes/is active. If the charging current is or becomes higher, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the maximum current over the entire Charging Session. This restriction can make a TariffElement become active when the charging current is below this value, but the TariffElement MUST no longer be active when the charging current raises above the defined value.
        , min_power NUMERIC(10, 4) DEFAULT NULL --Minimum power in kW, for example 5. When the EV is charging with more than, or equal to, the defined amount of power, this TariffElement is/becomes active. If the charging power is or becomes lower, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the minimum power over the entire Charging Session. This restriction can make a TariffElement become active when the charging power is above this value, but the TariffElement MUST no longer be active when the charging power drops below the defined value.
        , max_power NUMERIC(10, 4) DEFAULT NULL --Maximum power in kW, for example 20. When the EV is charging with less than the defined amount of power, this TariffElement becomes/is active. If the charging power is or becomes higher, this TariffElement is not or no longer valid and becomes inactive. This describes NOT the maximum power over the entire Charging Session. This restriction can make a TariffElement become active when the charging power is below this value, but the TariffElement MUST no longer be active when the charging power raises above the defined value.
        , min_duration INTEGER DEFAULT NULL --Minimum duration in seconds the Charging Session MUST last (inclusive). When the duration of a Charging Session is longer than the defined value, this TariffElement is or becomes active. Before that moment, this TariffElement is not yet active.
        , max_duration INTEGER DEFAULT NULL --Maximum duration in seconds the Charging Session MUST last (exclusive). When the duration of a Charging Session is shorter than the defined value, this TariffElement is or becomes active. After that moment, this TariffElement is no longer active.
        , day_of_week CLOB DEFAULT NULL --Which day(s) of the week this TariffElement is active.(DC2Type:simple_array)
        , reservation VARCHAR(255) DEFAULT NULL --When this field is present, the TariffElement describes reservation costs. A reservation starts when the reservation is made, and ends when the driver starts charging on the reserved EVSE/Location, or when the reservation expires. A reservation can only have: FLAT and TIME TariffDimensions, where TIME is for the duration of the reservation.
        , CONSTRAINT FK_31D90E65BB81B898 FOREIGN KEY (tariff_element_id) REFERENCES tariff_element (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_31D90E65BB81B898 ON tariff_restrictions (tariff_element_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE additional_geo_location');
        $this->addSql('DROP TABLE business_details');
        $this->addSql('DROP TABLE connector');
        $this->addSql('DROP TABLE connector_tariff');
        $this->addSql('DROP TABLE credentials');
        $this->addSql('DROP TABLE credentials_role');
        $this->addSql('DROP TABLE display_text');
        $this->addSql('DROP TABLE energy_mix');
        $this->addSql('DROP TABLE energy_source');
        $this->addSql('DROP TABLE environmental_impact');
        $this->addSql('DROP TABLE evse');
        $this->addSql('DROP TABLE evse_display_text');
        $this->addSql('DROP TABLE evse_image');
        $this->addSql('DROP TABLE exceptional_period');
        $this->addSql('DROP TABLE hours');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_display_text');
        $this->addSql('DROP TABLE price_component');
        $this->addSql('DROP TABLE publish_token_type');
        $this->addSql('DROP TABLE regular_hours');
        $this->addSql('DROP TABLE status_schedule');
        $this->addSql('DROP TABLE tariff');
        $this->addSql('DROP TABLE tariff_display_text');
        $this->addSql('DROP TABLE tariff_element');
        $this->addSql('DROP TABLE tariff_element_price_component');
        $this->addSql('DROP TABLE tariff_restrictions');
    }
}
