<?php

namespace Spatie\BpostAddressWebservice;

class Address
{
    /** @var string */
    public $streetName;

    /** @var string */
    public $streetNumber;

    /** @var string */
    public $boxNumber;

    /** @var string */
    public $postalCode;

    /** @var string */
    public $municipalityName;

    /** @var string */
    public $country = 'BELGIE';

    protected function __construct(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
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

    public function toArray(): array
    {
        return [
            'streetName' => $this->streetName,
            'streetNumber' => $this->streetNumber,
            'boxNumber' => $this->boxNumber,
            'postalCode' => $this->postalCode,
            'municipalityName' => $this->municipalityName,
            'country' => $this->country,
        ];
    }
}
