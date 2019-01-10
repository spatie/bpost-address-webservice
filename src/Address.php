<?php

namespace Spatie\BpostAddressWebservice;

use InvalidArgumentException;

class Address
{
    /** @var string */
    protected $streetName;

    /** @var string */
    protected $streetNumber;

    /** @var string */
    protected $boxNumber;

    /** @var string */
    protected $postalCode;

    /** @var string */
    protected $municipalityName;

    /** @var string */
    protected $country;

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

    public static function fromResponse(array $attributes): Address
    {
        return new static([
            'streetName' => $attributes['PostalAddress']['StructuredDeliveryPointLocation']['StreetName'] ?? '',
            'streetNumber' => $attributes['PostalAddress']['StructuredDeliveryPointLocation']['StreetNumber'] ?? '',
            'boxNumber' => $attributes['PostalAddress']['StructuredDeliveryPointLocation']['BoxNumber'] ?? '',
            'postalCode' => $attributes['PostalAddress']['StructuredPostalCodeMunicipality']['PostalCode'] ?? '',
            'municipalityName' => $attributes['PostalAddress']['StructuredPostalCodeMunicipality']['MunicipalityName'] ?? '',
            'country' => $attributes['PostalAddress']['CountryName'] ?? '',
        ]);
    }
}
