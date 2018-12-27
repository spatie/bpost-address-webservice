<?php

namespace Spatie\BpostAddressWebservice;

use InvalidArgumentException;

class Address
{
    public $street_name;
    public $street_number;
    public $box_number;
    public $postal_code;
    public $municipality_name;
    public $country;

    public function __construct(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if (! property_exists($this, $attribute)) {
                throw new InvalidArgumentException("Unknown attribute `$attribute`");
            }

            $this->$attribute = $value;
        }
    }

    public static function create(array $attributes): Address
    {
        return new static($attributes);
    }

    public static function createfromBpostArray(array $attributes): Address
    {
        return new static([
            'street_name' => $attributes['PostalAddress']['StructuredDeliveryPointLocation']['StreetName'] ?? '',
            'street_number' => $attributes['PostalAddress']['StructuredDeliveryPointLocation']['StreetNumber'] ?? '',
            'box_number' => $attributes['PostalAddress']['StructuredDeliveryPointLocation']['BoxNumber'] ?? '',
            'postal_code' => $attributes['PostalAddress']['StructuredPostalCodeMunicipality']['PostalCode'] ?? '',
            'municipality_name' => $attributes['PostalAddress']['StructuredPostalCodeMunicipality']['MunicipalityName'] ?? '',
            'country' => $attributes['PostalAddress']['CountryName'] ?? '',
        ]);
    }

    public function toBpostArray(): array
    {
        return [
            'PostalAddress' => [
                'DeliveryPointLocation' => [
                    'StructuredDeliveryPointLocation' => [
                        'StreetName' => $this->street_name,
                        'StreetNumber' => $this->street_number,
                        'BoxNumber' => $this->box_number,
                    ],
                ],
                'PostalCodeMunicipality' => [
                    'StructuredPostalCodeMunicipality' => [
                        'PostalCode' => $this->postal_code,
                        'MunicipalityName' => $this->municipality_name,
                    ],
                ],
            ],
            'DeliveringCountryISOCode' => $this->country,
        ];
    }
}
