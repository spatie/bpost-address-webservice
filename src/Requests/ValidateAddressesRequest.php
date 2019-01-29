<?php

namespace Spatie\BpostAddressWebservice\Requests;

use Spatie\BpostAddressWebservice\Address;

class ValidateAddressesRequest
{
    /** @var array */
    protected $addresses;

    /** @var array */
    protected $options;

    public function __construct(array $addresses, array $options)
    {
        $this->addresses = $addresses;

        $this->options = $options;
    }

    public function addresses(): array
    {
        return $this->addresses;
    }

    public function getBody(): array
    {
        $addresses = array_map(function (Address $address, int $i) {
            return [
                '@id' => $i,
                'PostalAddress' => [
                    'DeliveryPointLocation' => [
                        'StructuredDeliveryPointLocation' => [
                            'StreetName' => $address->streetName,
                            'StreetNumber' => $address->streetNumber,
                            'BoxNumber' => $address->boxNumber,
                        ],
                    ],
                    'PostalCodeMunicipality' => [
                        'StructuredPostalCodeMunicipality' => [
                            'PostalCode' => $address->postalCode,
                            'MunicipalityName' => $address->municipalityName,
                        ],
                    ],
                ],
                'DeliveringCountryISOCode' => $address->country,
            ];
        }, $this->addresses, array_keys(array_values($this->addresses)));

        return [
            'ValidateAddressesRequest' => [
                'AddressToValidateList' => [
                    'AddressToValidate' => $addresses,
                ],
                'ValidateAddressOptions' => $this->options,
            ],
        ];
    }
}
