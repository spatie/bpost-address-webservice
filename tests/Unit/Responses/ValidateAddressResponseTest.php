<?php

namespace Spatie\BpostAddressWebservice\Tests\Unit\Responses;

use PHPUnit\Framework\TestCase;
use Spatie\BpostAddressWebservice\Address;
use Spatie\Snapshots\MatchesSnapshots;
use Spatie\BpostAddressWebservice\Responses\ValidateAddressesResponse;

class ValidateAddressRequestTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_derives_validated_addresses_from_a_response_body_and_original_addresses()
    {
        $responseBody = [
            'ValidateAddressesResponse' => [
                'ValidatedAddressResultList' => [
                    'ValidatedAddressResult' => [
                        [
                            '@id' => '0',
                            'ValidatedAddressList' => [
                                'ValidatedAddress' => [
                                    [
                                        'PostalAddress' => [
                                            'StructuredDeliveryPointLocation' => [
                                                'StreetName' => 'SAMBERSTRAAT',
                                                'StreetNumber' => '69'
                                            ],
                                            'StructuredPostalCodeMunicipality' => [
                                                'PostalCode' => '2060',
                                                'MunicipalityName' => 'ANTWERPEN'
                                            ],
                                            'CountryName' => 'BELGIE'
                                        ],
                                        'AddressLanguage' => 'nl',
                                        'Label' => [
                                            'Line' => [
                                                'SAMBERSTRAAT 69',
                                                '2060 ANTWERPEN'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'Error' => [
                                [
                                    'ComponentRef' => 'MunicipalityName',
                                    'ErrorCode' => 'anomaly_in_field',
                                    'ErrorSeverity' => 'warning'
                                ]
                            ],
                            'DetectedInputAddressLanguage' => 'nl',
                            'TransactionID' => 'f579d528-3874-48ee-8eb9-7fe54ea39432'
                        ],
                    ]
                ]
            ]
        ];

        $originalAddresses = [
            Address::create([
                'streetName' => 'Samberstraat',
                'streetNumber' => '69',
                'boxNumber' => 'D',
                'postalCode' => '2060',
                'municipalityName' => 'Antwaarpe',
                'country' => 'BELGIE',
            ]),
        ];

        $validatedAddressResponse = new ValidateAddressesResponse($responseBody, $originalAddresses);

        $this->assertCount(1, $validatedAddressResponse->validatedAddresses());

        $this->assertEquals([
            'streetName' => 'SAMBERSTRAAT',
            'streetNumber' => '69',
            'boxNumber' => '',
            'postalCode' => '2060',
            'municipalityName' => 'ANTWERPEN',
            'country' => 'BELGIE',
        ], $validatedAddressResponse->validatedAddresses()[0]->toArray());

        $this->assertEquals([
            'streetName' => 'Samberstraat',
            'streetNumber' => '69',
            'boxNumber' => 'D',
            'postalCode' => '2060',
            'municipalityName' => 'Antwaarpe',
            'country' => 'BELGIE',
        ], $validatedAddressResponse->validatedAddresses()[0]->originalAddress()->toArray());
    }
}
