<?php

namespace Spatie\BpostAddressWebservice\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Spatie\BpostAddressWebservice\Address;

class AddressTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated_with_all_properties()
    {
        $address = Address::create([
            'streetName' => 'Samberstraat',
            'streetNumber' => '69',
            'boxNumber' => 'D',
            'postalCode' => '2060',
            'municipalityName' => 'Antwerpen',
            'country' => 'BELGIE',
        ]);

        $this->assertInstanceOf(Address::class, $address);

        $this->assertEquals([
            'streetName' => 'Samberstraat',
            'streetNumber' => '69',
            'boxNumber' => 'D',
            'postalCode' => '2060',
            'municipalityName' => 'Antwerpen',
            'country' => 'BELGIE',
        ], $address->toArray());
    }

    /** @test */
    public function it_can_be_created_from_an_api_response()
    {
        $response = [
            'PostalAddress' => [
                'StructuredDeliveryPointLocation' => [
                    'StreetName' => 'SAMBERSTRAAT',
                    'StreetNumber' => '69',
                    'BoxNumber' => 'D',
                ],
                'StructuredPostalCodeMunicipality' => [
                    'PostalCode' => '2060',
                    'MunicipalityName' => 'ANTWERPEN',
                ],
                'CountryName' => 'BELGIE',
            ],
        ];

        $address = Address::fromResponse($response);

        $this->assertInstanceOf(Address::class, $address);

        $this->assertEquals([
            'streetName' => 'SAMBERSTRAAT',
            'streetNumber' => '69',
            'boxNumber' => 'D',
            'postalCode' => '2060',
            'municipalityName' => 'ANTWERPEN',
            'country' => 'BELGIE',
        ], $address->toArray());
    }
}
