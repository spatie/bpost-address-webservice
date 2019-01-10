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

    public function getAddresses(): array
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
                            'StreetName' => $address->street_name,
                            'StreetNumber' => $address->street_number,
                            'BoxNumber' => $address->box_number,
                        ],
                    ],
                    'PostalCodeMunicipality' => [
                        'StructuredPostalCodeMunicipality' => [
                            'PostalCode' => $address->postal_code,
                            'MunicipalityName' => $address->municipality_name,
                        ],
                    ],
                ],
                'DeliveringCountryISOCode' => $address->country,
            ];
        }, $addresses, array_keys($addresses));

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
