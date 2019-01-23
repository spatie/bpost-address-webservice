<?php

namespace Spatie\BpostAddressWebservice;

use InvalidArgumentException;

/**
 * @property string streetName
 * @property string streetNumber
 * @property string boxNumber
 * @property string postalCode
 * @property string municipalityName
 * @property string country
 */
class Address
{
    /** @var string */
    private $streetName;

    /** @var string */
    private $streetNumber;

    /** @var string */
    private $boxNumber;

    /** @var string */
    private $postalCode;

    /** @var string */
    private $municipalityName;

    /** @var string */
    private $country = 'BELGIE';

    private function __construct(array $attributes)
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

    public function __get(string $key): string
    {
        return $this->toArray()[$key];
    }
}
